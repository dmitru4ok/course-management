## Course registration system database schema

**Faculty**(<ins>faculty_code</ins>, faculty_name) **DONE**

**StudyProgram**(<ins>program_code</ins>, program_name, program_type, is_valid, *faculty_code*) **DONE**

**StudyProgramInstance**(<ins>year_started, *program_code*</ins>, is_active) **DONE**

**Student**(<ins>stud_id</ins>, name, surname, email, is_valid, *year_started*, *program_code*) **DONE**

**Professor**(<ins>prof_id</ins>, name, surname, email, is_valid) **DONE**

**CourseBlueprint**(<ins>course_code</ins>, credit_weight, is_valid, *faculty_code*) **DONE**

**CourseOffering**(<ins>offering_id</ins>, date_to, date_from, classroom, *course_code*) # need seeder

**Semester**(<ins>*year_started*, *program_code*, sem_no</ins>, is_active, credits_required) **DONE**

**SemesterCourseRequirement**(<ins>*course_code*, *program_code*, *year_started*, *sem_no*</ins>) **DONE**

**Teaches**(<ins>*offering_id*, *prof_id*</ins>)

**AvailableIn**(<ins>*offering_id*, *sem_no*, *year_started*, *program_code*</ins>)

**CourseRegistration**(<ins>*stud_id*, *offering_id*, *program_code*, *year_started*</ins>, reg_date, is_compulsory)
