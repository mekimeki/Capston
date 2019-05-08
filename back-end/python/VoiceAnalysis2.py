import matplotlib.pyplot as plt
import numpy as np
import librosa as lib
import librosa.display


def getVar(path):
    wf, sr = lib.load(path)
    D = np.abs(lib.stft(wf))
    librosa.display.specshow(lib.amplitude_to_db)

def main():
    getVar("C:/Capston/back-end/public/audio/origin.wav")


if __name__ == "__main__":
    main()
