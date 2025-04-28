## Course registration system database schema

**Faculty**(<ins>faculty_code</ins>, faculty_name)

**StudyProgram**(<ins>program_code</ins>, program_name, program_type, program_type, *faculty_code*)

**StudyProgramInstance**(<ins>year_started, *program_code*</ins>, is_active)

**Student**(<ins>stud_id</ins>, name, surname, email, is_valid, *year_started*, *program_code*)

**Professor**(<ins>prof_id</ins>, name, surname, email, is_valid)

**CourseBlueprint**(<ins>course_code</ins>, credit_weight, is_valid, *faculty_code*)

**CourseOffering**(<ins>offering_id</ins>, date_to, date_from, classroom, *course_code*)

**Semester**(<ins>*year_started*, *program_code*, sem_no</ins>, is_active, credits_required)

**SemesterCourseRequirement**(<ins>*course_code*, *program_code*, *year_started*, *sem_no*</ins>)

**Teaches**(<ins>*offering_id*, *prof_id*</ins>)

**AvailableIn**(<ins>*offering_id*, *sem_no*, *year_started*, *program_code*</ins>)

**CourseRegistration**(<ins>*stud_id*, *offering_id*, *program_code*, *year_started*</ins>, reg_date, is_compulsory)
