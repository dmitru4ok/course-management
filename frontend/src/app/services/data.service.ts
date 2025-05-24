import { Injectable } from '@angular/core';
import { environment } from '../../environments/environment.development';
import { HttpClient } from '@angular/common/http';
import { CourseBluepint, Faculty, StudyProgram, StudyProgramInstance } from '../models/Data.models';
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

  public editCourseBlueprint(id: number, course: CourseBluepint) {
    if (course) {
      return this.http.put<CourseBluepint>(`${this.APIURL}/course_blueprints/${id}`, course);
    }
    return null;
  }

  public createCourseBlueprint(data: FormData) {
    return this.http.post<CourseBluepint>(`${this.APIURL}/course_blueprints`,data);
  }

  public getSyllabus(id: number) {
    return this.http.get(`${this.APIURL}/course_blueprints/${id}/syllabus`, {responseType: 'blob'});
  }

  public getStudyProgramsNested() {
    return this.http.get<StudyProgram[]>(`${this.APIURL}/study_programs_instances`);
  }

  public getStudyPrograms() {
    return this.http.get<StudyProgram[]>(`${this.APIURL}/study_programs`);
  }

  public getStudyProgramInstances() {
    return this.http.get<StudyProgramInstance[]>(`${this.APIURL}/study_programs`);
  }
}
