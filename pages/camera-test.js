import { useEffect, useRef, useState } from 'react';

export default function CameraTest() {
  const videoRef = useRef();
  const [stream, setStream] = useState(null);

  useEffect(() => {
    const startCamera = async () => {
      try {
        const isMobile = /Mobi|Android/i.test(navigator.userAgent);
        const constraints = {
          video: { facingMode: isMobile ? { exact: 'environment' } : 'user' },
        };

        const mediaStream = await navigator.mediaDevices.getUserMedia(constraints);
        videoRef.current.srcObject = mediaStream;
        setStream(mediaStream);
      } catch (err) {
        console.error('Camera error:', err);
      }
    };

    startCamera();

    // Stop stream on unmount
    return () => {
      if (stream) {
        stream.getTracks().forEach((track) => track.stop());
      }
    };
  }, []);

  return (
    <div style={{ width: '100%', maxWidth: '400px', margin: '0 auto' }}>
      <video
        ref={videoRef}
        autoPlay
        playsInline
        style={{ width: '100%', height: '400px', border: '1px solid black' }}
      />
      <p>Back camera on mobile, front camera on laptop.</p>
    </div>
  );
}
