import { DatePipe } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { StudyProgram } from '../models/Data.models';
import { DataService } from '../services/data.service';

@Component({
  selector: 'app-study-program',
  standalone: true,
  imports: [DatePipe],
  templateUrl: './study-program.component.html',
  styleUrl: './study-program.component.css'
})
export class StudyProgramComponent implements OnInit {

  constructor(private readonly data: DataService) {}

  ngOnInit(): void {
    this.data.getStudyPrograms().subscribe((data) => {
      this.studyPrograms = data;
      this.initOpens();

    });
  }

  initOpens() {
    for (let program of this.studyPrograms) {
      this.whoIsOpen[program.program_code] = {open: false, instances: {}};
      for (let instance of program.instances) {
        this.whoIsOpen[program.program_code].instances[instance.year_started] = false;
      }
    }
  }

  toggleProgram(pr_code: string) {
    this.whoIsOpen[pr_code].open = !this.whoIsOpen[pr_code].open;
  }

  toggleInstance(pr_code: string, yr_started: number) {
    this.whoIsOpen[pr_code].instances[yr_started] = !this.whoIsOpen[pr_code].instances[yr_started];
  }

  protected whoIsOpen: Record<string, {open: boolean; instances: Record<number, boolean>}> = {};
  protected studyPrograms: StudyProgram[] = [];
}
