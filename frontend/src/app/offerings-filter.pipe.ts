import { Pipe, PipeTransform } from '@angular/core';
import { CourseOfferingNested } from './models/Data.models';

@Pipe({
  name: 'offeringsFilter',
  standalone: true,
  pure: false
})
export class OfferingsFilterPipe implements PipeTransform {

  transform(courses: CourseOfferingNested[], filter: { name: string; hasSyllabus: string }): CourseOfferingNested[] {
    if (!courses) return [];

    const nameFilter = filter.name.toLowerCase().trim() || '';
    const syllabusFilter = filter.hasSyllabus;

    return courses.filter(course => {
      const nameMatches = nameFilter === '' || course.course_blueprint.course_name.toLowerCase().includes(nameFilter);

      let syllabusMatches = true;
      if (syllabusFilter === '1') {
        syllabusMatches = course.course_blueprint.has_syllabus_pdf === true;
      } else if (syllabusFilter === '0') {
        syllabusMatches = course.course_blueprint.has_syllabus_pdf === false;
      }

      return nameMatches && syllabusMatches;
    });
  }

}
