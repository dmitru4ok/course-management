export type CourseBluepint = {
  course_code: number,
  course_name: string,
  credit_weight: number,
  is_valid: boolean,
  faculty_code: string,
  has_syllabus_pdf: boolean
}

export type Faculty = {
  faculty_code: string,
  faculty_name: string
}

export type Semester = {
  sem_no: number,
  year_started: number,
  program_code: string,
  is_valid: boolean,
  date_from: string,
  date_to: string
}

export type StudyProgramInstance = {
  year_started: number,
  program_code: string,
  is_active: boolean,
  semesters: Array<Semester>
}

export type StudyProgramType = 'B' | 'M' | 'D'

export type StudyProgram = {
  program_code: string,
  program_name: string,
  program_type: StudyProgramType,
  faculty_code: string,
  is_valid: boolean,
  instances?: Array<StudyProgramInstance>
}
