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

  constructor(private readonly http: HttpClient) {
    this.context = this.getFromLocalStorage();
    if (this.context) {
      this.authState$.next(this.context?.user);
    }
  }

  public login(credentials: LoginForm): Observable<AuthContext> {
    return this.http.post<AuthContext>(`${this.APIURL}/login`, credentials)
    .pipe(
      tap(response => {
        console.log(response);
        this.context = response;
        this.authState$.next(this.context.user);
        this.writeToLocalStorage();
      })
    );
  }

  public getToken() {
    return this.context?.access_token;
  }

  public getRole() {
    return this.context?.user.role;
  }

  public writeToLocalStorage() {
    localStorage.setItem('authContext', JSON.stringify(this.context));
  }

  public clearLocalStorage() {
    localStorage.removeItem('authContext');
  }

  public getFromLocalStorage() {
    return JSON.parse(localStorage.getItem('authContext')!);
  }

  public logout(): Observable<any> {
    return this.http.post(`${this.APIURL}/logout`, {})
    .pipe(
      tap(() => {
        this.authState$.next(null);
        this.context = null;
        this.clearLocalStorage();
      })
    );
  }
}
