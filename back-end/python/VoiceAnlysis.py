import matplotlib.pyplot as plt
import numpy as np
import librosa as lib
import librosa.display


def getVar(path):

    # pitches, magnitudes = lib.piptrack(y=wf, sr=sr, fmin=50, fmax=500)

    # pitches = pitches[np.nonzero(pitches)]

    # # pitches = np.asarray(pitches)

    # # duration = np.array(list(range(0, duration)))

    # plt.subplot(211)
    # plt.plot(wf)
    # plt.title('wave')
    # plt.subplot(212)
    # plt.imshow(pitches, aspect="auto", interpolation="nearest", origin="bottom")
    # plt.plot(pitches)

    # plt.title("pitches")
    # plt.show()

    y, sr = librosa.load(path)
    # D = librosa.amplitude_to_db(np.abs(librosa.stft(y)), ref=np.max, top_db=10)
    duration = float(lib.get_duration(y=y, sr=sr))
    drf = lib.time_to_frames(duration, sr=sr)

    pits, mags = lib.piptrack(y=y, sr=sr, fmin=50, fmax=500)
    print("pits type === ", type(pits), end='\n')
    print("megs len === ", len(mags[0]), end='\n')
    print(np.shape(mags))
    plt.subplot(211)
    librosa.display.specshow(
        pits, x_axis='time', y_axis='log, frames', fmax=500)
    plt.title('pits')
    plt.subplot(212)
    librosa.display.specshow(mags, x_axis='time', y_axis='log')
    plt.title('mags')
    # plt.plot(duration)
    # plt.title("check duration")
    plt.show()


def main():
    getVar("C:/Capston/back-end/public/audio/origin.wav")


if __name__ == "__main__":
    main()
