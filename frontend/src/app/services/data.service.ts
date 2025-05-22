import { Injectable } from '@angular/core';
import { environment } from '../../environments/environment.development';
import { HttpClient } from '@angular/common/http';
import { CourseBluepint, Faculty } from '../models/Data.models';
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

  public getFaculties() {
    return this.http.get<Faculty[]>(`${this.APIURL}/faculties`);
  }

  public invalidateCourseBlueprint(course: CourseBluepint) {
    if (course.course_code) {
      return this.http.delete<CourseBluepint>(`${this.APIURL}/course_blueprints/${course.course_code}`);
    }
    return null;
  }

  public patchCourseBlueprint(course: CourseBluepint) {
    if (course.course_code) {
      // return this.http.patch()
    }
  }
}
