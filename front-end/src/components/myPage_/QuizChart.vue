<script>
import {
    Line
} from 'vue-chartjs'
import axios from "axios";

export default {
    extends: Line,
    props: ['data', 'options'],
    times: [],
    scores: [],
    mounted() {
        var form = new FormData();
        form.append("id", '123@gmail.com')
        var baseURI = "http://192.168.0.19/api/testResult"
        axios.post(baseURI, form).then(result => {
            this.times = result.data.dates;
            this.scores = result.data.scores;
            console.log("점수 요청 성공", result);
            this.renderChart({
                labels: this.times,
                datasets: [{
                    label: '나의 성적',
                    backgroundColor: '#81D4FA',
                    borderWidth: 1,
                    data: this.scores
                }]
            })
        }).catch(error => {
            console.log("점수 요청 실패", error);
        })
    }
}
</script>
