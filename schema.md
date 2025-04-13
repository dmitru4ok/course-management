## Course registration system database schema

**Faculty**(<ins>faculty_code</ins>, faculty_name)

**StudyProgramInstance**(<ins>years_started, program_code</ins>, program_name, program_type, *faculty_code*)

**Student**(<ins>stud_id</ins>, name, surname, email, is_valid, *year_started*, *program_code*)

**Professor**(<ins>prof_id</ins>, name, surname, email, is_valid)

**CourseBlueprint**(<ins>course_code</ins>, credit_weight, is_valid, *faculty_code*)

**CourseOffering**(<ins>offering_id</ins>, date_to, date_from, classroom, *course_code*)

**Semester**(<ins>*year_started*, *program_code*, sem_no</ins>, is_valid)

**Teaches**(<ins>*offering_id*, *prof_id*</ins>)

**AvailableIn**(<ins>*offering_id*, *sem_no*, *year_started*, *program_code*</ins>)

**CourseRegistration**(<ins>*stud_id*, *offering_id*, *program_code*, *year_started*, reg_date, is_compulsory</ins>)
