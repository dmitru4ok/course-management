export interface CourseBluepint {
    course_code: number,
    course_name: string,
    credit_weight: number,
    is_valid: boolean,
    faculty_code: string
}

export interface Faculty {
  faculty_code: string,
  faculty_name: string
}
