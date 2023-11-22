// chart utilizasi
var options = {
    series: [{
    name: 'Idle',
    data: [44, 55, 41, 37, 22, 43, 21]
  }, {
    name: 'Running',
    data: [53, 32, 33, 52, 13, 43, 32]
  }, {
    name: 'Workpiece',
    data: [12, 17, 11, 9, 15, 11, 20]
  }, {
    name: 'Breakdown',
    data: [9, 7, 5, 8, 6, 9, 4]
  }, {
    name: 'Tools',
    data: [25, 12, 19, 32, 25, 24, 10]
  }],
    chart: {
    type: 'bar',
    height: 350,
    stacked: true,
    stackType: '100%'
  },
  plotOptions: {
    bar: {
      horizontal: true,
    },
  },
  stroke: {
    width: 1,
    colors: ['#fff']
  },
 
  xaxis: {
    categories: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum'],
  },
  fill: {
    opacity: 1
  },
  legend: {
    position: 'top',
    horizontalAlign: 'left',
    offsetX: 90
  }
};

  var chart = new ApexCharts(document.querySelector("#machineUtilizationDaily"), options);
  chart.render();

//   end chart utilisasi

// chart utilizasi

var options = {
  series: [{
  name: 'Idle',
  data: [44, 55, 41, 37, 22, 43, 21]
}, {
  name: 'Running',
  data: [53, 32, 33, 52, 13, 43, 32]
}, {
  name: 'Workpiece',
  data: [12, 17, 11, 9, 15, 11, 20]
}, {
  name: 'Breakdown',
  data: [9, 7, 5, 8, 6, 9, 4]
}, {
  name: 'Tools',
  data: [25, 12, 19, 32, 25, 24, 10]
}],
  chart: {
  type: 'bar',
  height: 350,
  stacked: true,
  stackType: '100%'
},
plotOptions: {
  bar: {
    horizontal: true,
  },
},
stroke: {
  width: 1,
  colors: ['#fff']
},

xaxis: {
  categories: ['Honing', 'Lathe 1', 'Lathe 2', 'Milling 1', 'Milling 2', 'Polish 1', 'Polish 2'],
},
fill: {
  opacity: 1
},
legend: {
  position: 'top',
  horizontalAlign: 'left',
  offsetX: 90
}
};

var chart = new ApexCharts(document.querySelector("#utilizationHistory"), options);
chart.render();

//   end chart utilisasi


// all progress
var options = {
    chart: {
      height: 280,
      type: "radialBar",
    },
  
    series: [90],
    colors: ["#20E647"],
    plotOptions: {
      radialBar: {
        hollow: {
          margin: 0,
          size: "70%",
          background: "#293450"
        },
        track: {
          dropShadow: {
            enabled: true,
            top: 2,
            left: 0,
            blur: 4,
            opacity: 0.15
          }
        },
        dataLabels: {
          name: {
            offsetY: -10,
            color: "#fff",
            fontSize: "13px"
          },
          value: {
            color: "#fff",
            fontSize: "30px",
            show: true
          }
        }
      }
    },
    fill: {
      type: "gradient",
      gradient: {
        shade: "dark",
        type: "vertical",
        gradientToColors: ["#87D4F9"],
        stops: [0, 100]
      }
    },
    stroke: {
      lineCap: "round"
    },
    labels: ["Progress"]
  };
  
  var chart = new ApexCharts(document.querySelector("#allActual"), options);
  
  chart.render();
  
// end all progress

// Weekly Consumption
var options = {
  series: [25, 15, 44, 55],
  chart: {
  width: '100%',
  type: 'pie',
},
labels: ["Monday", "Tuesday", "Wednesday", "Thursday"],
theme: {
  monochrome: {
    enabled: true
  }
},
plotOptions: {
  pie: {
    dataLabels: {
      offset: -5
    }
  }
},

dataLabels: {
  formatter(val, opts) {
    const name = opts.w.globals.labels[opts.seriesIndex]
    return [name, val.toFixed(1) + '%']
  }
},
legend: {
  show: false
}
};

var chart = new ApexCharts(document.querySelector("#weeklyConsumption"), options);
chart.render();
// end consumption

// energy
var options = {
  series: [{
  name: 'series1',
  data: [31, 40, 28, 51, 42, 109, 100]
}],
  chart: {
  height: 350,
  type: 'area'
},
dataLabels: {
  enabled: false
},
stroke: {
  curve: 'smooth'
},
xaxis: {
  type: 'datetime',
  categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z"]
},
tooltip: {
  x: {
    format: 'dd/MM/yy HH:mm'
  },
},
};

var chart = new ApexCharts(document.querySelector("#energy"), options);
chart.render();
// end energy

// weekdayConsumption
var options = {
  series: [25, 15, 44, 55, 41, 17],
  chart: {
  width: '100%',
  type: 'pie',
},
labels: ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
theme: {
  monochrome: {
    enabled: true
  }
},
plotOptions: {
  pie: {
    dataLabels: {
      offset: -5
    }
  }
},

dataLabels: {
  formatter(val, opts) {
    const name = opts.w.globals.labels[opts.seriesIndex]
    return [name, val.toFixed(1) + '%']
  }
},
legend: {
  show: false
}
};

var chart = new ApexCharts(document.querySelector("#weekdayConsumption"), options);
chart.render();
// End WeekdayConsumption

// monthly Consumption
var options = {
  series: [{
  name: 'Inflation',
  data: [2.3, 3.1, 4.0, 10.1, 4.0, 3.6, 3.2, 2.3, 1.4, 0.8, 0.5, 0.2]
}],
  chart: {
  height: 350,
  type: 'bar',
},
plotOptions: {
  bar: {
    borderRadius: 10,
    dataLabels: {
      position: 'top', // top, center, bottom
    },
  }
},
dataLabels: {
  enabled: true,
  formatter: function (val) {
    return val + "%";
  },
  offsetY: -20,
  style: {
    fontSize: '12px',
    colors: ["#304758"]
  }
},

xaxis: {
  categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
  position: 'top',
  axisBorder: {
    show: false
  },
  axisTicks: {
    show: false
  },
  crosshairs: {
    fill: {
      type: 'gradient',
      gradient: {
        colorFrom: '#D8E3F0',
        colorTo: '#BED1E6',
        stops: [0, 100],
        opacityFrom: 0.4,
        opacityTo: 0.5,
      }
    }
  },
  tooltip: {
    enabled: true,
  }
},
yaxis: {
  axisBorder: {
    show: false
  },
  axisTicks: {
    show: false,
  },
  labels: {
    show: false,
    formatter: function (val) {
      return val + "%";
    }
  }

},
title: {
  text: 'Monthly Inflation in Argentina, 2002',
  floating: true,
  offsetY: 330,
  align: 'center',
  style: {
    color: '#444'
  }
}
};

var chart = new ApexCharts(document.querySelector("#monthlyConsumption"), options);
chart.render();

// End monthly consumption

// Annual consumption
var options = {
  series: [{
  name: 'Inflation',
  data: [2.3, 3.1, 4.0, 10.1, 4.0, 3.6, 3.2, 2.3, 1.4, 0.8, 0.5, 0.2]
}],
  chart: {
  height: 350,
  type: 'bar',
},
plotOptions: {
  bar: {
    borderRadius: 10,
    dataLabels: {
      position: 'top', // top, center, bottom
    },
  }
},
dataLabels: {
  enabled: true,
  formatter: function (val) {
    return val + "%";
  },
  offsetY: -20,
  style: {
    fontSize: '12px',
    colors: ["#304758"]
  }
},

xaxis: {
  categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
  position: 'top',
  axisBorder: {
    show: false
  },
  axisTicks: {
    show: false
  },
  crosshairs: {
    fill: {
      type: 'gradient',
      gradient: {
        colorFrom: '#D8E3F0',
        colorTo: '#BED1E6',
        stops: [0, 100],
        opacityFrom: 0.4,
        opacityTo: 0.5,
      }
    }
  },
  tooltip: {
    enabled: true,
  }
},
yaxis: {
  axisBorder: {
    show: false
  },
  axisTicks: {
    show: false,
  },
  labels: {
    show: false,
    formatter: function (val) {
      return val + "%";
    }
  }

},
title: {
  text: 'Monthly Inflation in Argentina, 2002',
  floating: true,
  offsetY: 330,
  align: 'center',
  style: {
    color: '#444'
  }
}
};

var chart = new ApexCharts(document.querySelector("#annualConsumption"), options);
chart.render();
// End Annual