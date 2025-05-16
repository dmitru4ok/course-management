import { HttpErrorResponse, HttpInterceptorFn } from '@angular/common/http';
import { inject } from '@angular/core';
import { AuthService } from './services/auth.service';
import { catchError, throwError } from 'rxjs';

export const authInterceptor: HttpInterceptorFn = (req, next) => {
  const auth = inject(AuthService);
  const token = auth.getToken();

  const authReq = token
    ? req.clone({headers: req.headers.set('Authorization', `Bearer ${token}`)})
    : req;
  return next(authReq).pipe(
    catchError((err: HttpErrorResponse) => {
      auth.logout();
      return throwError(() => err);
    })
  );
};
