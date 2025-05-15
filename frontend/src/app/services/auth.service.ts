import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { AuthContext, LoginForm, User } from '../models/Auth.models';
import { BehaviorSubject, Observable, tap } from 'rxjs';
import { environment } from '../../environments/environment.development';

@Injectable({
  providedIn: 'root'
})
export class AuthService {
  private readonly APIURL = environment.apiUri;
  private context: AuthContext | null = null;
  private readonly authState$ = new BehaviorSubject<User|null>(null);
  authentication$ = this.authState$.asObservable();

  constructor(private readonly http: HttpClient) {}

  public login(credentials: LoginForm): Observable<AuthContext> {
    return this.http.post<AuthContext>(`${this.APIURL}/login`, credentials)
    .pipe(
      tap(response => {
        console.log(response);
        this.context = response;
        this.authState$.next(this.context.user);
      })
    );
  }

  public getToken() {
    return this.context?.access_token;
  }

  public logout(): Observable<any> {
    return this.http.post(`${this.APIURL}/logout`, {})
    .pipe(
      tap(response => {
        this.authState$.next(null);
        this.context = null;
        console.log(response)
      })
    );
  }
}
