<template>
    <div>
        <column-chart
            :colors="['#00d5ff']"
            :data="chartData"
            :min="0"
            :max="300"
            width="800px"
            height="550px"
            xtitle="学習日"
            ytitle="1日の合計学習時間"
        ></column-chart>
    </div>
</template>

<script>
export default {
    data() {
        return {
            chartData: [],
        };
    },
    mounted() {
        this.fetchDuration();
    },
    methods: {
        fetchDuration() {
            axios
                .get("/records/getTotalStudyTime")
                .then((response) => {
                    this.chartData = response.data[0];
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>
