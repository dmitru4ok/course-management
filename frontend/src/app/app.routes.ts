import { Routes } from '@angular/router';
import { LoginComponent } from './login/login.component';
import { RegisterComponent } from './register/register.component';
import { UserRole } from './models/Auth.models';
import { DashboardComponent } from './dashboard/dashboard.component';
import { isAllowedRoleGuard } from './guards/auth.guard';
import { redirectGuard } from './guards/redirect.guard';
import { CourseComponent } from './course/course.component';

export const routes: Routes = [

  {path: 'login', component: LoginComponent},

  {path: 'admin',
    canActivateChild: [isAllowedRoleGuard([UserRole.ADMIN])], children: [
      {path: '', pathMatch: 'full', redirectTo: 'courses'},
      {path: 'courses', component: CourseComponent},
      {path: 'register', component: RegisterComponent},
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
