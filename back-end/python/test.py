import librosa
import numpy
import matplotlib.pylab as plt


def extract_max(pitches, magnitudes, shape):
    new_pitches = []
    new_magnitudes = []
    for i in range(0, shape[1]):
        new_pitches.append(numpy.max(pitches[:, i]))
        new_magnitudes.append(numpy.max(magnitudes[:, i]))
    return (new_pitches, new_magnitudes)


def smooth(x, window_len=11, window='hanning'):
    s = numpy.r_[2*x[0]-x[window_len-1::-1], x, 2*x[-1]-x[-1:-window_len:-1]]
    if window == 'flat':  # moving average
        w = numpy.ones(window_len, 'd')
    else:
        w = eval('numpy.'+window+'(window_len)')
    y = numpy.convolve(w/w.sum(), s, mode='same')
    return y[window_len:-window_len+1]


def plot(vector, name, xlabel=None, ylabel=None):
    plt.figure()
    plt.plot(vector)
    plt.xlabel(xlabel)
    plt.ylabel(ylabel)
    plt.plot()
    plt.savefig(name)


def set_variables(sample_f, duration, window_time, fmin, fmax, overlap):
    total_samples = sample_f * duration
    # There are sample_f/1000 samples / ms
    # windowsize = number of samples in one window
    window_size = sample_f/1000 * window_time
    hop_length = total_samples / window_size
    # Calculate number of windows needed
    needed_nb_windows = total_samples / (window_size - overlap)
    n_fft = needed_nb_windows * 2.0
    return total_samples, window_size, needed_nb_windows, n_fft, hop_length


def analyse(y, sr, n_fft, hop_length, fmin, fmax):
    pitches, magnitudes = librosa.core.piptrack(
        y=y, sr=sr, S=None, n_fft=n_fft, hop_length=hop_length, fmin=fmin, fmax=fmax, threshold=0.75)
    shape = numpy.shape(pitches)
    #nb_samples = total_samples / hop_length
    nb_samples = shape[0]
    #nb_windows = n_fft / 2
    nb_windows = shape[1]
    pitches, magnitudes = extract_max(pitches, magnitudes, shape)

    pitches1 = smooth(pitches, window_len=50)
    # pitches2 = smooth(pitches, window_len=55)
    # pitches3 = smooth(pitches, window_len=60)
    # pitches4 = smooth(pitches, window_len=40)
    plot(pitches1, 'pitches1')
    return pitches1

    # plot(pitches1, 'pitches1')
    # plot(pitches2, 'pitches2')
    # plot(pitches3, 'pitches3')
    # plot(pitches4, 'pitches4')
    # plot(magnitudes, 'magnitudes')
    # plot(y, 'audio')

def main():
    # Set all wanted variables

    # we want a sample frequency of 16 000
    sample_f = 16000
    
    # We want a windowsize of 30 ms
    window_time = 60

    fmin = 80
    fmax = 500

    # We want an overlap of 10 ms
    overlap = 20
     
    # y = audio time series
    # sr = sampling rate of y

    y, sr = librosa.load(
        "C:/Capston/back-end/public/audio/origin.wav", sr=sample_f)

    # for recording wav
    duration = int(librosa.get_duration(y=y, sr=sr))
    
    total_samples, window_size, needed_nb_windows, n_fft, hop_length =set_variables(
        sample_f, duration, window_time, fmin, fmax, overlap)

    n_fft = int(n_fft)
    hop_length = int(hop_length)

    return analyse(y, sr, n_fft, hop_length, fmin, fmax)


if __name__ == "__main__":
    data = main()