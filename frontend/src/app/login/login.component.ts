import { Component } from '@angular/core';
import { AuthService } from '../services/auth.service';
import { FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { LoginForm, UserRole } from '../models/Auth.models';
import { Router, RouterModule } from '@angular/router';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [ReactiveFormsModule, RouterModule],
  templateUrl: './login.component.html',
  styleUrl: './login.component.css'
})
export class LoginComponent {
  protected loginForm: FormGroup;
  constructor(private readonly auth: AuthService, private readonly router: Router) {
    this.loginForm = new FormGroup({
      'email': new FormControl(null, {validators: [Validators.required, Validators.email]}),
      'password': new FormControl(null, {validators: [Validators.required]})
    });
  }

  handleLogin() {
    const loginCeredentials: LoginForm = this.loginForm.value;

    this.auth.login(loginCeredentials).subscribe({
      error: (errValue) => {
        console.log(errValue);
      },
      next: (value) => {
        let path: Array<string>;
        if (value.user.role === UserRole.STUDENT) {
          path = ['my-courses'];
        } else if (value.user.role === UserRole.ADMIN) {
          path = ['admin', 'register'];
        } else if (value.user.role === UserRole.PROFESSOR) {
          path = ['professor', 'courses'];
        } else {
          path = ['login'];
        }
        this.router.navigate(path);
      }
    });
  }
}
