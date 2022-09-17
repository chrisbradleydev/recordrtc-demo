<template>
  <div>
    <h1>Simple video recording using RecordRTC</h1>
    <br />
    <button :disabled="disabled" @click="startRec">Start Recording</button
    >&nbsp;&nbsp;
    <button :disabled="!disabled" @click="stopRec">Stop Recording</button>
    <hr />
    <video
      autoplay
      controls
      playsinline
      ref="video"
      height="500"
      width="700"
    ></video>
  </div>
</template>

<script>
import RecordRTC from 'recordrtc'

export default {
  name: 'VideoRecord',
  data() {
    return {
      backend: 'https://backend.demo.test',
      disabled: false,
      fileExt: 'webm',
      fileName: 'video',
      recorder: null,
    }
  },
  computed: {
    file() {
      return `${this.fileName}.${this.fileExt}`
    },
    filePath() {
      return `${this.backend}/${this.file}`
    },
    video() {
      return this.$refs['video']
    },
  },
  methods: {
    captureCamera(callback) {
      navigator.mediaDevices
        .getUserMedia({audio: true, video: true})
        .then(function (camera) {
          callback(camera)
        })
        .catch(function (error) {
          alert('Unable to capture your camera. Please check console logs.')
          console.error(error)
        })
    },
    saveBlob(blob) {
      const fileType = 'video'
      const formData = new FormData()
      formData.append(fileType + '-filename', this.file)
      formData.append(fileType + '-blob', blob)
      this.xhr(`${this.backend}/save.php`, formData, () => {
        console.log(`${this.file} saved`)
      })
    },
    startRec() {
      this.disabled = true
      this.captureCamera(camera => {
        this.video.muted = true
        this.video.volume = 0
        this.video.srcObject = camera

        this.recorder = RecordRTC(camera, {
          type: 'video',
        })
        this.recorder.startRecording()
        this.recorder.camera = camera
        this.disabled = true
      })
    },
    stopRec() {
      this.disabled = false
      this.recorder.stopRecording(this.stopRecordingCallback)
    },
    stopRecordingCallback() {
      const blob = this.recorder.getBlob()
      this.saveBlob(blob)

      this.video.src = null
      this.video.srcObject = null
      this.video.muted = false
      this.video.volume = 1
      this.video.src = URL.createObjectURL(blob)

      this.recorder.camera.stop()
      this.recorder.destroy()
      this.recorder = null
    },
    xhr(url, data, callback) {
      const request = new XMLHttpRequest()
      request.onreadystatechange = function () {
        if (request.readyState === 4 && request.status === 200) {
          callback(location.href + request.responseText)
        }
      }
      request.open('POST', url)
      request.send(data)
    },
  },
}
</script>

<style scoped>
button {
  background-color: #42b883;
  border: none;
  border-radius: 2px;
  padding: 6px;
}
</style>
