from flask import Flask, render_template, Response
from flask_socketio import SocketIO
import cv2
import mediapipe as mp

app = Flask(__name__)
socketio = SocketIO(app)

# Configuración de MediaPipe
mp_hands = mp.solutions.hands
hands = mp_hands.Hands(static_image_mode=False,
                       max_num_hands=1, min_detection_confidence=0.7)
mp_draw = mp.solutions.drawing_utils


def detectar_seña(landmarks):
    # Lógica de conteo de dedos
    dedos_abiertos = []
    ids_puntas = [8, 12, 16, 20]
    for id_punta in ids_puntas:
        if landmarks[id_punta].y < landmarks[id_punta - 2].y:
            dedos_abiertos.append(True)
        else:
            dedos_abiertos.append(False)

    conteo = dedos_abiertos.count(True)
    if conteo >= 4:
        return "HOLA"
    return "..."


def generar_frames():
    cap = cv2.VideoCapture(0)
    ultima_seña = ""

    while True:
        success, frame = cap.read()
        if not success:
            break

        frame = cv2.flip(frame, 1)
        rgb_frame = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)
        results = hands.process(rgb_frame)

        seña_actual = "..."

        if results.multi_hand_landmarks:
            for hand_landmarks in results.multi_hand_landmarks:
                mp_draw.draw_landmarks(
                    frame, hand_landmarks, mp_hands.HAND_CONNECTIONS)
                seña_actual = detectar_seña(hand_landmarks.landmark)

                # Si la seña cambia, avisar al HTML vía Socket.io
                if seña_actual != ultima_seña and seña_actual != "...":
                    socketio.emit('nueva_seña', {'palabra': seña_actual})
                    ultima_seña = seña_actual

        # Codificar el frame para mostrarlo en el <img> del HTML
        ret, buffer = cv2.imencode('.jpg', frame)
        frame = buffer.tobytes()
        yield (b'--frame\r\n'
               b'Content-Type: image/jpeg\r\n\r\n' + frame + b'\r\n')


@app.route('/')
def index():
    return render_template('videollamada.html')  # el archivo HTML


@app.route('/video_feed')
def video_feed():
    return Response(generar_frames(), mimetype='multipart/x-mixed-replace; boundary=frame')


if __name__ == '__main__':
    socketio.run(app, debug=True)
