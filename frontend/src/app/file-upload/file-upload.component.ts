import { Component, EventEmitter, Output } from '@angular/core';

@Component({
  selector: 'app-file-upload',
  standalone: true,
  imports: [],
  templateUrl: './file-upload.component.html',
  styleUrl: './file-upload.component.css'
})
export class FileUploadComponent {

  @Output('userSelectedFile') fileEvent = new EventEmitter<File>;
  constructor() {}
  onFileSelected(event: any ) {
    if (event.target.files && event.target.files.length > 0) {
      this.fileEvent.emit(event.target.files[0]);
    }
  }
}
