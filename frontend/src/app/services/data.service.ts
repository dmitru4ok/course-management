import { Injectable } from '@angular/core';
import { environment } from '../../environments/environment.development';
import { HttpClient } from '@angular/common/http';

@Injectable({
  providedIn: 'root'
})
export class DataService {
  private readonly APIURL = environment.apiUri;

  constructor(private readonly http: HttpClient) {}
}
