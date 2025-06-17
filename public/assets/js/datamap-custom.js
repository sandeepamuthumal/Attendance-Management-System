//  Basic Map //
var basic = new Datamap({
    element: document.getElementById('map-1'),
    fills: {
        defaultFill: '#134D80',
      //   horizontalStripe: 'url(#horizontal-stripe)',
      //  verticalStripe: 'url(#vertical-stripe)',
    },
  });
  
// Basic Choropleth //
var basic_choropleth = new Datamap({
    element: document.getElementById('basic_choropleth'),
    projection: 'mercator',
    fills: {
        defaultFill: '#f39159',
        authorHasTraveledTo: '#ffcb00',
    },
    data: {
        USA: { fillKey: 'authorHasTraveledTo' },
        JPN: { fillKey: 'authorHasTraveledTo' },
        ITA: { fillKey: 'authorHasTraveledTo' },
        CRI: { fillKey: 'authorHasTraveledTo' },
        KOR: { fillKey: 'authorHasTraveledTo' },
        DEU: { fillKey: 'authorHasTraveledTo' },
    },
});

var colors = d3.scale.category10();

window.setInterval(function () {
basic_choropleth.updateChoropleth({
    USA: colors(Math.random() * 10),
    RUS: colors(Math.random() * 100),
    AUS: { fillKey: 'authorHasTraveledTo' },
    BRA: colors(Math.random() * 50),
    CAN: colors(Math.random() * 50),
    ZAF: colors(Math.random() * 50),
    IND: colors(Math.random() * 50),
});
}, 2000);

  // Area Bubbles //
  var bubble_map = new Datamap({
    element: document.getElementById('bubbles'),
    geographyConfig: {
      popupOnHover: false,
      highlightOnHover: false,
    },
    fills: {
      defaultFill: '#54d2d2',
      USA:  '#ffcb00',
      RUS:  '#f39159',
    },
  });
  bubble_map.bubbles(
    [
      {
        name: 'Not a bomb, but centered on Brazil',
        radius: 23,
        centered: 'BRA',
        country: 'USA',
        yeild: 0,
        fillKey: 'USA',
        date: '1954-03-01',
      },
      {
        name: 'Not a bomb',
        radius: 15,
        yeild: 0,
        country: 'USA',
        centered: 'USA',
        date: '1986-06-05',
        significance: 'Centered on US',
        fillKey: 'USA',
      },
      {
        name: 'Castle Bravo',
        radius: 25,
        yeild: 1500,
        country: 'USA',
        significance: 'First dry fusion fuel "staged" thermonuclear weapon; a serious nuclear fallout accident occurred',
        fillKey: 'USA',
        date: '1954-03-01',
        latitude: 11.415,
        longitude: 165.1619, 
      },
      {
        name: 'Tsar Bomba',
        radius: 70,
        yeild: 500,
        country: 'USSR',
        fillKey: 'RUS',
        significance: 'Largest thermonuclear weapon ever testedâ€”scaled down from its initial 100 Mt design by 50%',
        date: '1961-10-31',
        latitude: 73.482,
        longitude: 54.5854,
      },
    ],
    {},
  );
  
  // Projection Map //
  var map = new Datamap({
    scope: 'world',
    element: document.getElementById('projection_map'),
    projection: 'orthographic',
    fills: {
      defaultFill: '#cccccc',
      gt50: colors(Math.random() * 20),
      eq50: colors(Math.random() * 20),
      lt25: colors(Math.random() * 10),
      gt75: colors(Math.random() * 200),
      lt50: colors(Math.random() * 20),
      eq0: colors(Math.random() * 1),
      pink: '#0fa0fa',
      gt500: colors(Math.random() * 1),
    },
    projectionConfig: {
      rotation: [97, -30],
    },
    data: {
      USA: { fillKey: 'lt50' },
      MEX: { fillKey: 'lt25' },
      CAN: { fillKey: 'gt50' },
      GTM: { fillKey: 'gt500' },
      HND: { fillKey: 'eq50' },
      BLZ: { fillKey: 'pink' },
      GRL: { fillKey: 'eq0' },
      CAN: { fillKey: 'gt50' },
    },
  });
  
  map.graticule();
  
  map.arc(
    [
      {
        origin: {
          latitude: 61,
          longitude: -149,
        },
        destination: {
          latitude: -22,
          longitude: -43,
        },
      },
    ],
    {
      greatArc: true,
      animationSpeed: 2000,
    },
  );
  
  // Con Fig  //
  var defaultOptions = {
    scope: 'world', //currently supports 'usa' and 'world', however with custom map data you can specify your own
    //returns a d3 path and projection functions
    projection: 'equirectangular', //style of projection to be used. try "mercator"
    height: null, //if not null, datamaps will grab the height of 'element'
    width: null, //if not null, datamaps will grab the width of 'element'
    responsive: true, //if true, call `resize()` on the map object when it should adjust it's size
    done: function () {}, //callback when the map is done drawing
    fills: {
      defaultFill: '#ffcb00', //the keys in this object map to the "fillKey" of [data] or [bubbles]
    },
    dataType: 'json', //for use with dataUrl, currently 'json' or 'csv'. CSV should have an `id` column
    dataUrl: null, //if not null, datamaps will attempt to fetch this based on dataType ( default: json )
    geographyConfig: {
      dataUrl: null, //if not null, datamaps will fetch the map JSON (currently only supports topojson)
      hideAntarctica: true,
      borderWidth: 1,
      borderOpacity: 1,
      borderColor: '#00000',
      popupTemplate: function (geography, data) {
        //this function should just return a string
        return '<div class="hoverinfo"><strong>' + geography.properties.name + '</strong></div>';
      },
      popupOnHover: true, //disable the popup while hovering
      highlightOnHover: true,
      highlightFillColor: '#000000',
      highlightBorderColor: '#000000',
      highlightBorderWidth: 2,
      highlightBorderOpacity: 1,
    },
    bubblesConfig: {
      borderWidth: 2,
      borderOpacity: 1,
      borderColor: '#000000',
      popupOnHover: true,
      radius: null,
      popupTemplate: function (geography, data) {
        return '<div class="hoverinfo"><strong>' + data.name + '</strong></div>';
      },
      fillOpacity: 0.75,
      animate: true,
      highlightOnHover: true,
      highlightFillColor: '#000000',
      highlightBorderColor: '#000000',
      highlightBorderWidth: 2,
      highlightBorderOpacity: 1,
      highlightFillOpacity: 0.85,
      exitDelay: 100,
      key: JSON.stringify,
    },
    arcConfig: {
      strokeColor: '#000000',
      strokeWidth: 1,
      arcSharpness: 1,
      animationSpeed: 600,
    },
  };