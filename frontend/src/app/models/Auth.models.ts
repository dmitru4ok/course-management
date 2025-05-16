export interface LoginForm {
  email: string,
  password: string
}

export interface User {
  user_id: number,
  email: string,
  role: string,
  name: string,
  surname: string,
  program_code: string|null,
  year_started: number|null
}

export interface AuthContext {
  access_token: string,
  expires_in: number,
  user: User
}

export enum UserRole {
  STUDENT = 'S',
  ADMIN = 'A',
  PROFESSOR = 'P'
}
