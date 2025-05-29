import { Component } from '@angular/core';
import { switchMap, tap } from 'rxjs';
import { DataService } from '../services/data.service';
import { CourseBluepint, CourseOfferingNested, Faculty } from '../models/Data.models';
import { FormControl, FormGroup, FormsModule, ReactiveFormsModule, Validators } from '@angular/forms';
import { OfferingsFilterPipe } from '../offerings-filter.pipe';

@Component({
  selector: 'app-course-offerings',
  standalone: true,
  imports: [ReactiveFormsModule, FormsModule, OfferingsFilterPipe],
  templateUrl: './course-offerings.component.html',
  styleUrl: './course-offerings.component.css'
})
export class CourseOfferingsComponent {
  filter: {name: string, hasSyllabus: string} = {name: '', hasSyllabus: ''};
  offeringForm: FormGroup;
  blueprints: CourseBluepint[] = [];
  courses: CourseOfferingNested[] = [];
  faculties: Faculty[] = [];

  constructor(private readonly data: DataService) {
    this.offeringForm = new FormGroup({
      course_code: new FormControl(null, [Validators.required]),
      building: new FormControl(null, [Validators.required, Validators.maxLength(255)]),
      classroom: new FormControl(null, [Validators.required])
    });
  }

  ngOnInit(): void {
    this.data.getCourseOfferings().
      pipe(
        switchMap((offerings) => {
          this.courses = offerings;
          console.log(this.courses);
          return this.data.getCourseBluepints();
        }),
        tap((bluepr) => {
          this.blueprints = bluepr;
          console.log(this.blueprints);
        })
      ).subscribe();
  }

  openSyllabus(id: number) {
    this.data.getSyllabus(id).subscribe(blob => {
      const url = window.URL.createObjectURL(blob);
      window.open(url, '_blank');
    });
  }

  addOffering() {
    console.log(this.offeringForm.value);
  }
}
