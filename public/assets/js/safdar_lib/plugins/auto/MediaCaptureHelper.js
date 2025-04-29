export default class MediaCaptureHelper {
    constructor({ videoSelector, previewSelector, inputSelector }) {
      this.videoEl = document.querySelector(videoSelector);
      this.previewEl = document.querySelector(previewSelector);
      this.inputEl = document.querySelector(inputSelector);
  
      this.mediaStream = null;
      this.mediaRecorder = null;
      this.chunks = [];
    }
  
    async startCamera() {
      try {
        this.mediaStream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
        this.videoEl.srcObject = this.mediaStream;
        this.videoEl.play();
      } catch (error) {
        console.error('Camera access denied:', error);
      }
    }
  
    takePhoto() {
      if (!this.videoEl || !this.videoEl.videoWidth) return;
  
      const canvas = document.createElement('canvas');
      canvas.width = this.videoEl.videoWidth;
      canvas.height = this.videoEl.videoHeight;
      canvas.getContext('2d').drawImage(this.videoEl, 0, 0);
  
      const dataUrl = canvas.toDataURL('image/png');
      this.previewEl.innerHTML = `<img src="${dataUrl}" class="rounded border" />`;
      this.inputEl.value = dataUrl;
    }
  
    startRecording() {
      if (!this.mediaStream) return;
      this.chunks = [];
  
      this.mediaRecorder = new MediaRecorder(this.mediaStream);
  
      this.mediaRecorder.ondataavailable = (e) => this.chunks.push(e.data);
      this.mediaRecorder.onstop = () => {
        const blob = new Blob(this.chunks, { type: 'video/webm' });
        const videoUrl = URL.createObjectURL(blob);
  
        const videoPreview = document.createElement('video');
        videoPreview.controls = true;
        videoPreview.src = videoUrl;
        videoPreview.className = 'rounded border w-full';
        this.previewEl.innerHTML = '';
        this.previewEl.appendChild(videoPreview);
  
        const reader = new FileReader();
        reader.onloadend = () => {
          this.inputEl.value = reader.result;
        };
        reader.readAsDataURL(blob);
      };
  
      this.mediaRecorder.start();
    }
  
    stopRecording() {
      if (this.mediaRecorder && this.mediaRecorder.state === 'recording') {
        this.mediaRecorder.stop();
      }
    }
  }
  