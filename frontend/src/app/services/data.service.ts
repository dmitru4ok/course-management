import { Injectable } from '@angular/core';
import { environment } from '../../environments/environment.development';
import { HttpClient } from '@angular/common/http';
import { CourseBluepint } from '../models/Data.models';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root'
})
export class DataService {
  private readonly APIURL = environment.apiUri;

  constructor(private readonly http: HttpClient) {}

  public getCourseBluepints(): Observable<CourseBluepint[]> {
    return this.http.get<CourseBluepint[]>(`${this.APIURL}/course_blueprints`);
  }
}
