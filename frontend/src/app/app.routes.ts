import { Routes } from '@angular/router';
import { LoginComponent } from './login/login.component';
import { RegisterComponent } from './register/register.component';
import { UserRole } from './models/Auth.models';
import { DashboardComponent } from './dashboard/dashboard.component';
import { isAllowedRoleGuard } from './guards/auth.guard';
import { redirectGuard } from './guards/redirect.guard';

export const routes: Routes = [
  {path: 'login', component: LoginComponent},
  {path: 'admin', component: RegisterComponent,
    canActivate: [isAllowedRoleGuard([UserRole.ADMIN])],
    canActivateChild: [isAllowedRoleGuard([UserRole.ADMIN])],
    children: [
    {path: 'register', component: RegisterComponent},
    {path: 'dashboard', component: DashboardComponent}
  ]},
  { path: '**', canActivate: [redirectGuard], redirectTo:''}

];
