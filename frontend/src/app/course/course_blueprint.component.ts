import { Component, OnInit } from '@angular/core';
import { CourseBluepint } from '../models/Data.models';
import { DataService } from '../services/data.service';

@Component({
  selector: 'app-course',
  standalone: true,
  imports: [],
  templateUrl: './course_blueprint.component.html',
  styleUrl: './course_blueprint.component.css'
})
export class CourseComponent implements OnInit {
  private courses: CourseBluepint[] = [];
  constructor(private readonly data: DataService){}

  ngOnInit(): void {
    this.data.getCourseBluepints().subscribe({
      next: (value) => {
        this.courses = value;
        console.log(this.courses);
      }
    });
  }

}

