import { inject } from '@angular/core';
import { CanActivateFn, Router } from '@angular/router';
import { AuthService } from '../services/auth.service';
import { UserRole } from '../models/Auth.models';

export const redirectGuard: CanActivateFn = (route, state) => {
  const role = inject(AuthService).getRole();
  const router = inject(Router);
  switch (role) {
    case UserRole.ADMIN: {
      router.navigate(['/admin', 'dashboard']);
      break;
    }

    case UserRole.PROFESSOR: {
      router.navigate(['/admin', 'dashboard']);
      break;
    }

    case UserRole.STUDENT: {
      router.navigate(['/admin', 'dashboard']);
      break;
    }

    default: {
      router.navigate(['/login']);
    }
  }

  return false;
};
