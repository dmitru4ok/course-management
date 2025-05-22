import { Component, OnInit } from '@angular/core';
import { CourseBluepint, Faculty } from '../models/Data.models';
import { DataService } from '../services/data.service';
import { NgClass } from '@angular/common';
import { RouterLink } from '@angular/router';
import { FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';

@Component({
  selector: 'app-course',
  standalone: true,
  imports: [NgClass, RouterLink, ReactiveFormsModule],
  templateUrl: './course_blueprint.component.html',
  styleUrl: './course_blueprint.component.css'
})
export class CourseComponent implements OnInit {
  protected courses: CourseBluepint[] = [];
  protected faculties: Faculty[] = [];
  protected editForm!: FormGroup;
  protected selectedCourse: CourseBluepint | null = null;
  constructor(private readonly data: DataService){}

  ngOnInit(): void {
    this.data.getCourseBluepints().subscribe({
      next: (value) => {
        this.courses = value;
        console.log(this.courses);
      }
    });

    this.editForm = new FormGroup({
      course_name: new FormControl(null, [Validators.required, Validators.maxLength(100)]),
      credit_weight: new FormControl(null, [Validators.required, Validators.min(0), Validators.max(255)]),
      is_valid: new FormControl(false, Validators.required),
      faculty_code: new FormControl(null, [Validators.required, Validators.maxLength(3)])
    });
  }

  onEdit(course: CourseBluepint) {
    if (this.faculties.length === 0) {
      this.data.getFaculties().subscribe((resp) => {
        this.faculties = resp;
        this.selectedCourse = course;
        this.editForm.patchValue(this.selectedCourse);
        console.log(this.editForm.value);
      });
    } else {
      this.selectedCourse = course;
      this.editForm.patchValue(this.selectedCourse);
      console.log(this.editForm.value);
    }

  }

  onInvalidate(course: CourseBluepint) {
    const data = this.data.invalidateCourseBlueprint(course);
    if (data) {
      data.subscribe((invalidated) => {
        this.courses.find((oldCourse) => oldCourse.course_code = course.course_code)!.is_valid = invalidated.is_valid;
      });
    }
  }

  onSave() {

  }

  cancelEdit() {
    this.editForm.reset();
    this.selectedCourse = null;
  }


}

