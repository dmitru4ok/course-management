import { Component, OnDestroy, OnInit } from '@angular/core';
import { DataService } from '../services/data.service';
import { ActivatedRoute } from '@angular/router';
import { FormControl, FormGroup, ReactiveFormsModule, Validators } from '@angular/forms';
import { StudyProgram } from '../models/Data.models';
import { Subscription } from 'rxjs';

@Component({
  selector: 'app-instantiate-study-program',
  standalone: true,
  imports: [ReactiveFormsModule],
  templateUrl: './instantiate-study-program.component.html',
  styleUrl: './instantiate-study-program.component.css'
})
export class InstantiateStudyProgramComponent implements OnInit, OnDestroy {

  studyPrograms: StudyProgram[] = [];
  years_available: number[] = [];
  deepCopySubs: Subscription;
  constructor(private readonly data: DataService, private readonly route: ActivatedRoute) {
    this.instantiateForm = new FormGroup({
      'program_code': new FormControl(),
      'year_started': new FormControl(),
      'perform_deep_copy': new FormControl(false, Validators.required),
      'copy_program_code': new FormControl(),
      'copy_program_year': new FormControl()
    });

    this.deepCopySubs = this.instantiateForm.get('copy_program_code')!.valueChanges
      .subscribe((value) => {
        this.instantiateForm.patchValue({'copy_program_year': null});
        const programObj = this.studyPrograms.find(el => el.program_code === value);
        if (programObj?.instances) {
          this.years_available = programObj.instances.map(instance => instance.year_started);
        }
        console.log(this.instantiateForm.value);
      });
  }

  instantiateForm!: FormGroup;
  ngOnInit(): void {
    this.data.getStudyProgramsNested().subscribe(data => {
      this.studyPrograms = data;
      console.log(this.studyPrograms);
      const code_passed = this.route.snapshot.queryParamMap.get('code');
      if (code_passed && this.studyPrograms.find(el => el.program_code === code_passed)) {
        this.instantiateForm.patchValue({'program_code': code_passed});
      }
    });
  }

  onStudyProgramInstantiate() {

  }

  ngOnDestroy() {
    this.deepCopySubs.unsubscribe();
  }
}
