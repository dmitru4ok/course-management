import { Component, OnInit } from '@angular/core';
import { CourseBluepint, Faculty } from '../models/Data.models';
import { DataService } from '../services/data.service';
import { NgClass } from '@angular/common';
import { RouterLink } from '@angular/router';
import { FormControl, FormGroup, FormsModule, ReactiveFormsModule, Validators } from '@angular/forms';
import { CourseFilterPipe } from '../course-filter.pipe';
import { switchMap, tap } from 'rxjs';
import { FileUploadComponent } from "../file-upload/file-upload.component";

type State = 'edit' | 'create' | 'view';

@Component({
  selector: 'app-course',
  standalone: true,
  imports: [NgClass, RouterLink, ReactiveFormsModule, FormsModule, CourseFilterPipe, FileUploadComponent],
  templateUrl: './course_blueprint.component.html',
  styleUrl: './course_blueprint.component.css'
})
export class CourseComponent implements OnInit {
  protected courses: CourseBluepint[] = [];
  protected faculties: Faculty[] = [];
  protected editForm!: FormGroup;
  protected selectedCourse: CourseBluepint | null = null;
  protected state: State = 'view';
  searchQuery = {
    name: '',
    credits: 0,
    faculty: '',
    validity: ''
  }
  constructor(private readonly data: DataService){}

  ngOnInit(): void {
    this.data.getCourseBluepints().
    pipe(
      switchMap((course_blueprint) => {

        this.courses = course_blueprint;
        console.log(this.courses);
        return this.data.getFaculties();
      }),
      tap((f) => this.faculties = f)
    ).
     subscribe();

    this.editForm = new FormGroup({
      course_name: new FormControl(null, [Validators.required, Validators.maxLength(100)]),
      credit_weight: new FormControl(null, [Validators.required, Validators.min(0), Validators.max(255)]),
      is_valid: new FormControl(true, Validators.required),
      faculty_code: new FormControl(null, [Validators.required, Validators.maxLength(3)]),
      syllabus_pdf: new FormControl(null)
    });
  }

  createNewCourseBlueprint() {
    const fd = new FormData();
    for (let key in this.editForm.value) {
      if (key === 'is_valid') {
        if (this.editForm.value[key] === true || this.editForm.value[key] === '1' || this.editForm.value[key] === 'true') {
          fd.append('is_valid', 'true');
        } else if (this.editForm.value[key] === false || this.editForm.value[key] === '0' || this.editForm.value[key] === 'false') {
          fd.append('is_valid', 'false');
        }
      } else {
        fd.append(key, this.editForm.value[key]);
      }
    }
  }

  switchToState(state: State) {
    this.state = state;
  }

  attachFileToAForm(file: File) {
    this.editForm.patchValue({
      'syllabus_pdf': file
    });
    console.log(this.editForm.value);
  }

  onEdit(course: CourseBluepint) {
    this.selectedCourse = course;
    this.editForm.patchValue(this.selectedCourse);
    console.log(this.selectedCourse);
    this.switchToState('edit');
  }

  onInvalidate(course: CourseBluepint) {
    const data = this.data.invalidateCourseBlueprint(course);
    if (data) {
      data.subscribe((invalidated) => {
        this.courses.find((oldCourse) => oldCourse.course_code === course.course_code)!.is_valid = invalidated.is_valid;
      });
    }
  }

  onEditSave() {
    console.log(this.selectedCourse, this.editForm.value);
    let respObservable;
    if (this.selectedCourse) {
      const val = this.editForm.value['is_valid'];
      if (val === true || val === 'true' || val === '1') {
        this.editForm.patchValue({'is_valid': 'true'});
      } else if (val === false || val === 'false' || val === '0') {
        this.editForm.patchValue({'is_valid': 'false'});
      }


      respObservable = this.data.editCourseBlueprint(this.selectedCourse.course_code, this.editForm.value);
    } else {
      return;
    }
    if (respObservable) {
      respObservable.subscribe((data) => {
        console.log(data);
        const ind = this.courses.findIndex( elem => elem.course_code === this.selectedCourse!.course_code);
        this.courses[ind] = data;
        this.selectedCourse = null;
      });

    }
    this.switchToState('view');
    this.editForm.reset({is_valid: true});
  }

  onSave() {
    if (this.state === 'edit') {
      this.onEditSave();
    } else {
      this.onCreateSave();
    }
  }

  openSyllabus(id: number) {
    this.data.getSyllabus(id).subscribe(blob => {
      const url = window.URL.createObjectURL(blob);
      window.open(url, '_blank');
    });
  }

  onCreateSave() {
    const fd = new FormData();
    for (let key in this.editForm.value) {
      console.log(key, this.editForm.value[key]);
      if (this.editForm.value[key]) {
        fd.append(key, this.editForm.value[key]);
      }
    }
    this.data.createCourseBlueprint(fd).subscribe((blueprint) => {
      this.courses.push(blueprint);
      this.switchToState('view');
    });
  }

  cancelEdit() {
    this.editForm.reset({is_valid: true});
    this.switchToState('view');
    this.selectedCourse = null;
  }
}

