import { Routes } from '@angular/router';
import { LoginComponent } from './login/login.component';
import { RegisterComponent } from './register/register.component';
import { UserRole } from './models/Auth.models';
import { DashboardComponent } from './dashboard/dashboard.component';
import { isAllowedRoleGuard } from './guards/auth.guard';
import { redirectGuard } from './guards/redirect.guard';
import { CourseComponent } from './course/course_blueprint.component';
import { StudyProgramComponent } from './study-program/study-program.component';
import { InstantiateStudyProgramComponent } from './instantiate-study-program/instantiate-study-program.component';
import { CourseOfferingsComponent } from './course-offerings/course-offerings.component';

export const routes: Routes = [

  {path: 'login', component: LoginComponent},

  {path: 'admin',
    canActivateChild: [isAllowedRoleGuard([UserRole.ADMIN])], children: [
      {path: '', pathMatch: 'full', redirectTo: 'courses'},
      {path: 'courses', component: CourseComponent},
      {path: 'course-offerings', component: CourseOfferingsComponent},
      {path: 'register', component: RegisterComponent},
      {path: 'study-programs', children: [
        {path: '', pathMatch: 'full', component: StudyProgramComponent},
        {path: 'instantiate', component: InstantiateStudyProgramComponent}
      ]}
  ]},

  {path: 'student',
    canActivateChild: [], children: [
      // {path: '', pathMatch: 'full', redirectTo: }
  ]},

  {path: 'professor',
    canActivateChild: [], children: [
      // {path: '', pathMatch: 'full', redirectTo: }
  ]},

  // {path: '', pathMatch: 'full', redirectTo: 'admin'},
  // { path: '**', canActivate: [redirectGuard], redirectTo:''}

];
