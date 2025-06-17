(function () {
  "use strict";
  var options = {
    series: [
      {
        name: "Statistics",
        data: [20, 60, 50, 70, 40, 80, 5],
      },
      {
        name: "Statistics",
        data: [80, 40, 50, 30, 60, 20, 10],
      },
    ],
    chart: {
      type: "bar",
      height: 110,
      stacked: true,
      stackType: "100%",
      toolbar: {
        show: false,
      },
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: "40px",
        borderRadius: 2,
      },
    },
    grid: {
      show: false,
      xaxis: {
        lines: {
          show: false,
        },
      },
    },
    states: {
      hover: {
        filter: {
          type: "darken",
          value: 1,
        },
      },
    },
    dataLabels: {
      enabled: false,
    },
    legend: {
      show: false,
    },
    colors: [AdmiroAdminConfig.primary, "#D5E8E6"],
    xaxis: {
      show: false,
      labels: {
        show: false,
      },
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
    },
    yaxis: {
      labels: {
        show: false,
      },
    },
    tooltip: {
      marker: {
        show: false,
      },
      fixed: {
        enabled: false,
        position: "bottomRight",
        offsetX: 0,
        offsetY: 0,
      },
    },
    responsive: [
      {
        breakpoint: 1661,
        options: {
          chart: {
            width: 150,
          },
        },
      },
      {
        breakpoint: 1300,
        options: {
          chart: {
            width: 130,
          },
        },
      },
      {
        breakpoint: 670,
        options: {
          chart: {
            offsetX: -30,
          },
        },
      },
    ],
  };
  var chart = new ApexCharts(document.querySelector("#sales-chart"), options);
  chart.render();
  ////visitor-chart
  var options = {
    series: [
      {
        name: "Statistics",
        data: [20, 60, 50, 70, 40, 80, 5],
      },
      {
        name: "Statistics",
        data: [80, 40, 50, 30, 60, 20, 10],
      },
    ],
    chart: {
      type: "bar",
      height: 110,
      stacked: true,
      stackType: "100%",
      toolbar: {
        show: false,
      },
    },
    plotOptions: {
      bar: {
        horizontal: false,
        columnWidth: "40px",
        borderRadius: 0,
      },
    },
    grid: {
      show: false,
      xaxis: {
        lines: {
          show: false,
        },
      },
    },
    states: {
      hover: {
        filter: {
          type: "darken",
          value: 1,
        },
      },
    },
    dataLabels: {
      enabled: false,
    },
    legend: {
      show: false,
    },
    colors: [AdmiroAdminConfig.secondary, "#faded1"],
    xaxis: {
      show: false,
      labels: {
        show: false,
      },
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
    },
    yaxis: {
      labels: {
        show: false,
      },
    },
    tooltip: {
      marker: {
        show: false,
      },
      fixed: {
        enabled: false,
        position: "bottomRight",
        offsetX: 0,
        offsetY: 0,
      },
    },
    responsive: [
      {
        breakpoint: 1661,
        options: {
          chart: {
            width: 150,
          },
        },
      },
      {
        breakpoint: 1300,
        options: {
          chart: {
            width: 130,
          },
        },
      },
      {
        breakpoint: 670,
        options: {
          chart: {
            offsetX: -30,
          },
        },
      },
    ],
  };
  var chart = new ApexCharts(document.querySelector("#visitor-chart"), options);
  chart.render();
  //////invest
  var options = {
    series: [76, 67, 61, 90],
    chart: {
      height: 300,
      type: "radialBar",
    },
    plotOptions: {
      radialBar: {
        offsetY: 0,
        startAngle: 0,
        endAngle: 270,
        hollow: {
          margin: 5,
          size: "30%",
          background: "transparent",
          image: undefined,
        },
        dataLabels: {
          name: {
            fontSize: "22px",
          },
          value: {
            fontSize: "16px",
          },
          total: {
            show: true,
            label: "Total",
            formatter: function (w) {
              return 249;
            },
          },
        },
        track: {
          background: "var(--body-color)",
        },
      },
    },
    
    colors: [
      AdmiroAdminConfig.primary, AdmiroAdminConfig.secondary, "#ea9200", "#e74b2b",
    ],
    labels: ["Vimeo", "Messenger", "Facebook", "LinkedIn"],
    legend: {
      labels: {
        useSeriesColors: true,
      },
      markers: {
        size: 0,
      },
      formatter: function (seriesName, opts) {
        return seriesName + ":  " + opts.w.globals.series[opts.seriesIndex];
      },
      itemMargin: {
        vertical: 2,
      },
    },
    responsive: [
      {
        breakpoint: 1445,

        options: {
          chart: {
            offsetX: -10,
          },
          legend: {
            show: false,
          },
          plotOptions: {
            radialBar: {
              hollow: {
                margin: 2,
                size: "20%",
              },
              dataLabels: {
                total: {
                  show: false,
                },
              },
            },
          },
        },
      },
      {
        breakpoint: 1435,

        options: {
          chart: {
            offsetX: 10,
          },
        },
      },
      {
        breakpoint: 1430,

        options: {
          chart: {
            offsetX: -10,
          },
        },
      },
      {
        breakpoint: 1400,

        options: {
          chart: {
            height: 250,
            offsetX: -10,
          },
        },
      },
      {
        breakpoint: 1240,

        options: {
          chart: {
            height: 235,
            offsetX: -10,
          },
        },
      },
      {
        breakpoint: 1200,
        options: {
          chart: {
            height: 300,
            offsetX: -10,
          },
          plotOptions: {
            radialBar: {
              hollow: {
                margin: 5,
                size: "30%",
              },
              dataLabels: {
                total: {
                  show: true,
                },
              },
            },
          },
        },
      },
    ],
  };

  var chart = new ApexCharts(document.querySelector("#investment"), options);
  chart.render();
  ////////////slider-js/////////////
  var swiper = new Swiper(".mySwiper1", {
    spaceBetween: 0,
    slidesPerView: 1,
    autoplay: {
      delay: 3000,
      disableOnInteraction: false,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });
  var swiper = new Swiper(".mySwiper2", {
    spaceBetween: 0,
    slidesPerView: 1,
    // grabCursor: true,
    autoplay: {
      delay: 3000,
      disableOnInteraction: false,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });
  /*=======/Sales Stats Radial Chart/=======*/
  const salesStatsOption = {
    series: [70],
    chart: {
      height: 345,
      type: "radialBar",
      offsetY: 0,
    },

    stroke: {
      dashArray: 20,
      curve: "smooth",
      lineCap: "round",
    },
    grid: {
      padding: {
        top: 0,
        left: 0,
        right: 0,
        bottom: 0,
      },
    },
    plotOptions: {
      radialBar: {
        startAngle: -135,
        endAngle: 135,
        hollow: {
          size: "75%",
          image: "../assets/images/apexchart/radial-image.png",
          imageWidth: 200,
          imageHeight: 200,
          imageClipped: false,
        },
        track: {
          show: true,
          background: "var(--body-color)",
          strokeWidth: "97%",
          opacity: 0.4,
        },
        dataLabels: {
          show: true,
          name: {
            show: true,
            fontSize: "20px",
            fontFamily: undefined,
            fontWeight: 600,
            color: undefined,
          },
          value: {
            show: true,
            fontFamily: '"Nunito Sans", sans-serif',
            fontWeight: 700,
            fontSize: "16px",
            color: "#292929",
            offsetY: 6,
            formatter: function (val) {
              return val + "%";
            },
          },
        },
      },
    },
    labels: ["Selling rate", "Returning: 3.2k"],
    colors: [AdmiroAdminConfig.primary, AdmiroAdminConfig.secondary],
    legend: {
      show: false,
    },
    responsive: [
      {
        breakpoint: 1621,
        options: {
          chart: {
            height: 340,
          },
          plotOptions: {
            radialBar: {
              startAngle: -135,
              endAngle: 135,
              hollow: {
                size: "75%",
                image: "../assets/images/apexchart/radial-image.png",
                imageWidth: 170,
                imageHeight: 170,
              },
            },
          },
        },
      },
      {
        breakpoint: 1581,
        options: {
          chart: {
            height: 300,
          },
          plotOptions: {
            radialBar: {
              dataLabels: {
                name: {
                  fontSize: "14px",
                },
                value: {
                  fontSize: "16px",
                },
              },
            },
          },
        },
      },
      {
        breakpoint: 531,
        options: {
          chart: {
            height: 300,
          },
          plotOptions: {
            radialBar: {
              hollow: {
                size: "70%",
                imageWidth: 150,
                imageHeight: 150,
              },
            },
          },
        },
      },
      {
        breakpoint: 426,
        options: {
          chart: {
            height: 280,
          },
          plotOptions: {
            radialBar: {
              hollow: {
                size: "70%",
                imageWidth: 100,
                imageHeight: 100,
              },
            },
          },
        },
      },
    ],
  };
  const salesStatsChartEl = new ApexCharts(
    document.querySelector("#salesStatsRadialChart"),
    salesStatsOption
  );
  salesStatsChartEl.render();
  ///growth-chart
  var options = {
    series: [
      {
        name: "Network",
        data: [
          {
            x: "Jan",
            y: 350,
          },
          {
            x: "Feb",
            y: 600,
          },
          {
            x: "Mar",
            y: 350,
          },
          {
            x: "Apr",
            y: 410,
          },
          {
            x: "May",
            y: 410,
          },
          {
            x: "Jun",
            y: 600,
          },
          {
            x: "Jul",
            y: 500,
          },
          {
            x: "Aug",
            y: 500,
          },
          {
            x: "Sep",
            y: 800,
          },
          {
            x: "Oct",
            y: 410,
          },
          {
            x: "Nov",
            y: 350,
          },
          {
            x: "Dec",
            y: 410,
          },
        ],
      },
    ],
    chart: {
      type: "area",
      height: 330,
      animations: {
        enabled: false,
      },
      zoom: {
        enabled: false,
      },
      toolbar: {
        show: false,
      },
    },
    dataLabels: {
      enabled: false,
    },
    stroke: {
      curve: "straight",
    },
    grid: {
      show: true,
      borderColor: "#e5e5e5",
    },
    fill: {
      opacity: 0.8,
      type: "gradient",
      gradient: {
        shade: "light",
        type: "vertical",
        shadeIntensity: 0.5,
        gradientToColors: undefined,
        inverseColors: true,
        opacityFrom: 1,
        opacityTo: 0,
        stops: [0, 100],
        colorStops: [],
      },
    },
    colors: [AdmiroAdminConfig.primary],
    markers: {
      size: 6,
      colors: "#ffffff",
      strokeColor: AdmiroAdminConfig.primary,
      strokeWidth: 3,
      strokeOpacity: 1,
      fillOpacity: 0,
      hover: {
        size: 9,
      },
    },
    tooltip: {
      intersect: true,
      shared: false,
    },
    theme: {
      palette: "palette1",
    },
    yaxis: {
      categories: [
        "000k",
        "100k",
        "200k",
        "300k",
        "400k",
        "500k",
        "300k",
        "400k",
        "500k",
      ],
      labels: {
        formatter: function (val) {
          return val + "k";
        },
        style: {
          fontSize: "13px",
          fontFamily: "Nunito Sans, sans-serif",
          colors: "#AAA3A0",
          fontWeight: 600,
        },
      },
    },
    xaxis: {
      labels: {
        style: {
          fontSize: "13px",
          fontFamily: "Nunito Sans', sans-serif",
          colors: "#AAA3A0",
          fontWeight: 600,
        },
      },
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
    },
  };

  var chart = new ApexCharts(document.querySelector("#growth-chart"), options);
  chart.render();
  // profit chart
  var options3 = {
    series: [
      {
        name: "Desktops",
        data: [210, 180, 650, 200, 600, 100, 800, 300, 500],
      },
    ],
    chart: {
      width: 200,
      height: 150,
      type: "line",
      toolbar: {
        show: false,
      },
      dropShadow: {
        enabled: true,
        enabledOnSeries: undefined,
        top: 5,
        left: 0,
        blur: 3,
        color: AdmiroAdminConfig.secondary,
        opacity: 0.3,
      },
      zoom: {
        enabled: false,
      },
    },
    colors: [AdmiroAdminConfig.secondary],
    dataLabels: {
      enabled: false,
    },
    stroke: {
      width: 2,
      curve: "smooth",
    },
    grid: {
      show: false,
    },
    tooltip: {
      x: {
        show: false,
      },
      y: {
        show: false,
      },
      z: {
        show: false,
      },
      marker: {
        show: false,
      },
    },
    xaxis: {
      categories: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
      ],
      labels: {
        show: false,
      },
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
      tooltip: {
        enabled: false,
      },
    },
    yaxis: {
      labels: {
        show: false,
      },
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
    },
    responsive: [
      {
        breakpoint: 1780,
        options: {
          chart: {
            width: 180,
          },
        },
      },
      {
        breakpoint: 1680,
        options: {
          chart: {
            width: 160,
          },
        },
      },
      {
        breakpoint: 1601,
        options: {
          chart: {
            height: 110,
          },
        },
      },
      {
        breakpoint: 1560,
        options: {
          chart: {
            width: 140,
          },
        },
      },
      {
        breakpoint: 1460,
        options: {
          chart: {
            width: 120,
          },
        },
      },
      {
        breakpoint: 1400,
        options: {
          chart: {
            width: 150,
          },
        },
      },
      {
        breakpoint: 1110,
        options: {
          chart: {
            width: 200,
          },
        },
      },
      {
        breakpoint: 700,
        options: {
          chart: {
            width: 150,
          },
        },
      },
      {
        breakpoint: 576,
        options: {
          chart: {
            width: 220,
          },
        },
      },
      {
        breakpoint: 420,
        options: {
          chart: {
            width: 150,
          },
        },
      },
    ],
  };

  var chart3 = new ApexCharts(
    document.querySelector("#profitchart1"),
    options3
  );
  chart3.render();
  // order chart
  var options2 = {
    series: [
      {
        name: "Daily",
        data: [
          2.15, 3, 1.5, 2, 2.4, 3, 2.4, 2.8, 1.5, 1.7, 3, 2.5, 3, 2, 2.15, 3,
          1.1,
        ],
      },
      {
        name: "Weekly",
        data: [
          -2.15, -3, -1.5, -2, -2.4, -3, -2.4, -2.8, -1.5, -1.7, -3, -2.5, -3,
          -2, -2.15, -3, -1.1,
        ],
      },
      {
        name: "Monthly",
        data: [
          -2.25, -2.35, -2.45, -2.55, -2.65, -2.75, -2.85, -2.95, -3.0, -3.1,
          -3.2, -3.25, -3.1, -3.0, -2.95, -2.85, -2.75,
        ],
      },
      {
        name: "Yearly",
        data: [
          2.25, 2.35, 2.45, 2.55, 2.65, 2.75, 2.85, 2.95, 3.0, 3.1, 3.2, 3.25,
          3.1, 3.0, 2.95, 2.85, 2.75,
        ],
      },
    ],
    chart: {
      type: "bar",
      width: 180,
      height: 120,
      stacked: true,
      toolbar: {
        show: false,
      },
    },
    plotOptions: {
      bar: {
        vertical: true,
        columnWidth: "40%",
        barHeight: "80%",
        startingShape: "rounded",
        endingShape: "rounded",
      },
    },
    colors: [
      AdmiroAdminConfig.primary,
      AdmiroAdminConfig.primary,
      "var(--body-color)",
      "var(--body-color)",
    ],
    dataLabels: {
      enabled: false,
    },
    stroke: {
      width: 0,
    },
    legend: {
      show: false,
    },
    grid: {
      xaxis: {
        offsetX: -2,
        lines: {
          show: false,
        },
      },
      yaxis: {
        lines: {
          show: false,
        },
      },
    },
    yaxis: {
      min: -5,
      max: 5,
      show: false,
      axisBorder: {
        show: false,
      },
      axisTicks: {
        show: false,
      },
    },
    tooltip: {
      shared: false,
      x: {
        show: false,
      },
      y: {
        show: false,
      },
      z: {
        show: false,
      },
    },
    xaxis: {
      categories: [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "July",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
      ],
      offsetX: 0,
      offsetY: 0,
      labels: {
        offsetX: 0,
        offsetY: 0,
        show: false,
      },
      axisBorder: {
        offsetX: 0,
        offsetY: 0,
        show: false,
      },
      axisTicks: {
        offsetX: 0,
        offsetY: 0,
        show: false,
      },
    },
    responsive: [
      {
        breakpoint: 1760,
        options: {
          chart: {
            width: 160,
          },
        },
      },
      {
        breakpoint: 1601,
        options: {
          chart: {
            height: 110,
          },
        },
      },
      {
        breakpoint: 1560,
        options: {
          chart: {
            width: 140,
          },
        },
      },
      {
        breakpoint: 1460,
        options: {
          chart: {
            width: 120,
          },
        },
      },
      {
        breakpoint: 1400,
        options: {
          chart: {
            width: 150,
          },
        },
      },
      {
        breakpoint: 1110,
        options: {
          chart: {
            width: 200,
          },
        },
      },
      {
        breakpoint: 700,
        options: {
          chart: {
            width: 150,
          },
        },
      },
      {
        breakpoint: 576,
        options: {
          chart: {
            width: 220,
          },
        },
      },
      {
        breakpoint: 420,
        options: {
          chart: {
            width: 150,
          },
        },
      },
    ],
  };

  var chart2 = new ApexCharts(document.querySelector("#orderchart1"), options2);

  chart2.render();
})();