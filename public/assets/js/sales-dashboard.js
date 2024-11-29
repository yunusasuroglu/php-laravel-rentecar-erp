// Earnings grafiği için başlangıçta boş bir seçenek objesi oluştur
var earningsOptions = {
  chart: {
    height: 300,
    toolbar: {
      show: false
    },
    dropShadow: {
      enabled: true,
      enabledOnSeries: undefined,
      top: 5,
      left: 0,
      blur: 3,
      color: ['var(--primary02)', 'rgba(245 ,187 ,116, 0.2)', "rgba(255,255,255,0)"],
      opacity: 0.5
    },
  },
  grid: {
    show: true,
    borderColor: 'rgba(119, 119, 142, 0.1)',
    strokeDashArray: 4,
  },
  dataLabels: {
    enabled: false
  },
  stroke: {
    width: [0, 2.5, 2.5],
    curve: "smooth",
  },
  legend: {
    show: true,
    position: 'top',
    horizontalAlign: 'center',
    fontWeight: 600,
    fontSize: '11px',
    tooltipHoverFormatter: function(val, opts) {
      return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
    },
    labels: {
      colors: '#74767c',
    },
    markers: {
      width: 8,
      height: 8,
      strokeWidth: 0,
      radius: 12,
      offsetX: 0,
      offsetY: 0
    },
  },
  series: [],
  colors: ["rgba(119, 119, 142, 0.075)", "rgba(0, 144, 172, 0.95)", "rgba(245 ,187 ,116)"],
  fill: {
    type: ['solid', 'gradient', 'gradient'],
    gradient: {
      gradientToColors: ["transparent", '#4776E6', '#f5bb74']
    },
  },
  yaxis: {
    title: {
      style: {
        color: '#adb5be',
        fontSize: '14px',
        fontFamily: 'poppins, sans-serif',
        fontWeight: 600,
        cssClass: 'apexcharts-yaxis-label',
      },
    },
    labels: {
      formatter: function(y) {
        return y.toFixed(0) + "";
      },
      show: true,
      style: {
        colors: "#8c9097",
        fontSize: '11px',
        fontWeight: 600,
        cssClass: 'apexcharts-xaxis-label',
      },
    }
  },
  xaxis: {
    type: 'day',
    categories: [], // API'den gelen tarih verileri buraya gelecek
    axisBorder: {
      show: true,
      color: 'rgba(119, 119, 142, 0.05)',
      offsetX: 0,
      offsetY: 0,
    },
    axisTicks: {
      show: true,
      borderType: 'solid',
      color: 'rgba(119, 119, 142, 0.05)',
      width: 6,
      offsetX: 0,
      offsetY: 0
    },
    labels: {
      rotate: -90,
      style: {
        colors: "#8c9097",
        fontSize: '11px',
        fontWeight: 600,
        cssClass: 'apexcharts-xaxis-label',
      },
    }
  },
};

// Earnings grafiğini oluştur
var earningsChart = new ApexCharts(document.querySelector("#earnings"), earningsOptions);
earningsChart.render();

// API'den veri alıp grafikleri güncelleyen fonksiyon
function fetchAndRefreshChartData(intervalType,option,text) {
  var apiUrl = `/api/contractData/${intervalType}`;
  fetch(apiUrl)
  .then(response => response.json())
  .then(data => {
    // API'den gelen verileri uygun formata dönüştür
    var categories = [];
    var intervalData = {};
    
    switch (intervalType) {
      case 'weekly':
      // Haftanın günlerini belirleme (Pazartesi'den Pazar'a kadar)
      categories = ['Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa', 'So'];
      intervalData = categories.reduce((acc, day) => ({ ...acc, [day]: { contractCount: 0, approvedCount: 0, invoiceCount: 0 } }), {});
      
      data.forEach(item => {
        var date = new Date(item.created_at);
        var weekDay = categories[(date.getDay() + 6) % 7]; // Pazartesi 0, Salı 1, ... , Pazar 6 olacak şekilde ayarlama
        intervalData[weekDay].contractCount += item.contractCount;
        intervalData[weekDay].approvedCount += item.approvedCount;
        intervalData[weekDay].invoiceCount += item.invoiceCount;
      });
      document.getElementById('selectedOption').innerText = 'Weekly Analysis';
      break;
      
      case 'monthly':
      categories = ['Jan', 'Feb', 'Mär', 'Apr', 'Mai', 'Jun', 'Jul', 'Aug', 'Sep', 'Okt', 'Nov', 'Dez'];
      intervalData = categories.reduce((acc, month) => ({ ...acc, [month]: { contractCount: 0, approvedCount: 0, invoiceCount: 0 } }), {});
      
      data.forEach(item => {
        var date = new Date(item.created_at);
        var monthName = categories[date.getMonth()];
        intervalData[monthName].contractCount += item.contractCount;
        intervalData[monthName].approvedCount += item.approvedCount;
        intervalData[monthName].invoiceCount += item.invoiceCount;
      });
      document.getElementById('selectedOption').innerText = 'Monthly Analysis';
      break;
      
      case 'yearly':
      categories = [...new Set(data.map(item => new Date(item.created_at).getFullYear().toString()))];
      intervalData = categories.reduce((acc, year) => ({ ...acc, [year]: { contractCount: 0, approvedCount: 0, invoiceCount: 0 } }), {});
      
      data.forEach(item => {
        var date = new Date(item.created_at);
        var year = date.getFullYear().toString();
        intervalData[year].contractCount += item.contractCount;
        intervalData[year].approvedCount += item.approvedCount;
        intervalData[year].invoiceCount += item.invoiceCount;
      });
      document.getElementById('selectedOption').innerText = 'Yearly Analysis';
      break;
      
      default:
      console.error('Geçersiz analiz türü:', intervalType);
      return;
    }
    var contractData = categories.map(day => intervalData[day].contractCount);
    var approvedData = categories.map(day => intervalData[day].approvedCount);
    var invoiceData = categories.map(day => intervalData[day].invoiceCount);
    
    
    // Grafik seçeneklerini güncelle ve yeniden çiz
    earningsChart.updateOptions({
      xaxis: {
        categories: categories
      },
      series: [{
        name: "Contract",
        data: contractData,
        type: 'bar',
      }, {
        name: 'Active Contract',
        data: approvedData,
        type: 'line',
      }, {
        name: "Invoice",
        data: invoiceData,
        type: 'line',
      }],
    });
  })
  .catch(error => {
    console.error('Veri alınamadı:', error);
  });
 
}
fetchAndRefreshChartData('weekly');

