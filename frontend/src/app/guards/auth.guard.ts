import { CanActivateFn } from '@angular/router';
import { inject } from '@angular/core';
import { AuthService } from '../services/auth.service';

export const isAllowedRoleGuard = function(allowedRoles: Array<string>): CanActivateFn {
  const retFn: CanActivateFn = (route, state) => {
    const userRole = inject(AuthService).getRole();
    if (!userRole) {
      return false;
    }
    return allowedRoles.includes(userRole);
  };
  return retFn;
}
