let queryableFunctions = {
  makeRequest: function (method, token, url) {
    if (arguments.length < 3) { throw new TypeError('reply - not enough arguments'); return; }

    const headers = new Headers({
      'X-CSRF-TOKEN': token,
      'X-Requested-With': 'XMLHttpRequest',
      'Content-Type': 'application/json'
    })

    const request = new Request(url, {
      method: method,
      headers: headers,
      mode: 'cors',
      cache: 'default'
    })

    fetch(request)
      .then((response) => {
        return response.json()
      }).then((json) => {
        reply('success', json)
      }).catch((error) => {
        throw error
      })
  }, 

  buildChartOptions: function (title, chartType, xColumnId, yColumnIds, data, columns) {
    if (arguments.length < 6) { throw new TypeError('reply - not enough arguments'); return; }
    
    try {
      let xColumn = getColumn(columns, xColumnId)
      let yColumns = getColumns(columns, yColumnIds)
      let chart = {
        type: chartType,
        height: 600
      }
      let xAxis = [{
        title: {
          text: xColumn.title
        },
        categories: data.map((datum) => datum[xColumnId])
      }]
      let yAxis = yColumns.map((column) => ({ title: { text: column.title }}))
      let series = yAxis.map((axis, index) => ({
        name: axis.title.text,
        yAxis: index,
        data: data.map((datum) => (typeof datum[yColumnIds[index]] === 'string') ? 
            Number(datum[yColumnIds[index]].replace(/,/g, '')) : 
            Number(datum[yColumnIds[index]]))
      }))

      let legend = {
        layout: 'vertical',
        floating: true,
        backgroundColor: '#FFFFFF',
        align: 'left',
        verticalAlign: 'bottom',
        y: -20,
        x: 0
      }

      reply('success', {
        title,
        chart,
        xAxis,
        yAxis,
        series,
        legend
      })
    } catch (error) {
      reply('error', error)
    }
  },

  buildMarkers: function (labelField, latitudeField, longitudeField, data) {
    try {
      let markers = data.map((datum) => ({
        latLng: [
          parseFloat(datum[latitudeField]),
          parseFloat(datum[longitudeField])
        ],
        label: datum[labelField]
      }))

      reply('success', markers)
    } catch (error) {
      reply('error', error)
    }
  }
}

var getColumn = (columns, id) => columns[columns.findIndex((column) => column.index == id)]

var getColumns = (columns, ids = []) => ids.map((id) => getColumn(columns, id))

function defaultReply(message) {
  // your default PUBLIC function executed only when main page calls the queryableWorker.postMessage() method directly
  // do something
}

function reply() {
  if (arguments.length < 1) { throw new TypeError('reply - not enough arguments'); return; }
  postMessage({ 'queryMethodListener': arguments[0], 'queryMethodArguments': Array.prototype.slice.call(arguments, 1) })
}

onmessage = function(oEvent) {
  if (oEvent.data instanceof Object && oEvent.data.hasOwnProperty('queryMethod') && oEvent.data.hasOwnProperty('queryMethodArguments')) {
    queryableFunctions[oEvent.data.queryMethod].apply(self, oEvent.data.queryMethodArguments)
  } else {
    defaultReply(oEvent.data);
  }
}
