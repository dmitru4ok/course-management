import { Pipe, PipeTransform } from '@angular/core';
import { CourseBluepint } from './models/Data.models';

@Pipe({
  name: 'courseFilter',
  standalone: true,
  pure: false
})
export class CourseFilterPipe implements PipeTransform {

  transform(courses: CourseBluepint[], filter: {
    name?: string,
    credits?: number,
    faculty?: string,
    validity?: boolean | string}): CourseBluepint[] {
      if (!courses || courses.length === 0) return [];
      return courses.filter(course => {
      const matchName = !filter.name || course.course_name.toLowerCase().includes(filter.name.toLowerCase());
      const matchCredits = !filter.credits || course.credit_weight === +filter.credits;
      const matchFaculty = !filter.faculty || course.faculty_code === filter.faculty;
      const matchValidity =
        filter.validity === '' || !filter.validity || String(course.is_valid) === String(filter.validity);

      return matchName && matchCredits && matchFaculty && matchValidity;
    });
  }

}
