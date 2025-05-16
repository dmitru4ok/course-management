import { Component } from '@angular/core';
import { AuthService } from '../services/auth.service';
import { AsyncPipe } from '@angular/common';
import { Router, RouterModule } from '@angular/router';
import { UserRole } from '../models/Auth.models';

@Component({
  selector: 'app-header',
  standalone: true,
  imports: [AsyncPipe, RouterModule],
  templateUrl: './header.component.html',
  styleUrl: './header.component.css'
})
export class HeaderComponent {
  constructor(protected readonly auth: AuthService, private readonly router: Router) {}
  UserRole = UserRole;

  logout() {
    this.auth.logout().subscribe(() => {
      this.router.navigate(['/login']);
    });
  }
}
