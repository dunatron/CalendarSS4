/* global google */
import _ from 'lodash';
import PropTypes from 'prop-types';

import {
  default as React,
  Component,
} from 'react';

import Helmet from 'react-helmet';

import {
  withGoogleMap,
  GoogleMap,
  Marker,
} from 'react-google-maps';

/*
 * This is the modify version of:
 * https://developers.google.com/maps/documentation/javascript/examples/event-arguments
 *
 * Add <script src="https://maps.googleapis.com/maps/api/js"></script> to your HTML to provide google.maps reference
 */
const GettingStartedGoogleMap = withGoogleMap(props => (
  <GoogleMap
    ref={props.onMapLoad}
    defaultZoom={props.theZoom}
    // defaultCenter={{ lat: 25.0112183, lng: 121.52067570000001 }}
    defaultCenter={props.theLatLng}
    // defaultCenter={{ lat: props.theLng, lng: 121.52067570000001 }}
    onClick={props.onMapClick}
  >
    {props.markers.map(marker => (
      <Marker
        {...marker}
        onRightClick={() => props.onMarkerRightClick(marker)}
      />
    ))}
  </GoogleMap>
));

class GettingStartedExample extends Component {

  constructor(props) {
    super(props);

    this.handleMapLoad = this.handleMapLoad.bind(this);
    this.handleMapClick = this.handleMapClick.bind(this);
    this.handleMarkerRightClick = this.handleMarkerRightClick.bind(this);
    this.handleSetLat = this.handleSetLat.bind(this);

    this.state = {
      markers: [{
        position: {
          lat: 25.0112183,
          lng: 121.52067570000001,
        },
        key: 'Taiwan',
        defaultAnimation: 2,
      }],
      myZoom: 15,
      myLatLng: { lat: 25.0112183, lng: 121.52067570000001 },
    };
  }

  // state = {
  //     markers: [{
  //         position: {
  //             lat: 25.0112183,
  //             lng: 121.52067570000001,
  //         },
  //         key: `Taiwan`,
  //         defaultAnimation: 2,
  //     }],
  //     myZoom: 15,
  //     myLatLng: { lat: 25.0112183, lng: 121.52067570000001 }
  // };


  handleMapLoad(map) {
    console.log(this.state.myZoom);


    this._mapComponent = map;

    this.setState({
      myZoom: 10,
    });
    console.log(this.state.myZoom);

    if (map) {
      console.log('do i have a MAP???');
      console.log(map.getZoom());
      console.log(this.state);
    }
    // For now can figure out how
  }

  /*
     * This is called when you click on the map.
     * Go and try click now.
     */
  handleMapClick(event) {
    const nextMarkers = [
      ...this.state.markers,
      {
        position: event.latLng,
        defaultAnimation: 2,
        key: Date.now(), // Add a key property for: http://fb.me/react-warning-keys
      },
    ];
    this.setState({
      markers: nextMarkers,
    });

    if (nextMarkers.length === 3) {
      this.props.toast(
        'Right click on the marker to remove it',
        'Also check the code!'
      );
    }
  }

  handleMarkerRightClick(targetMarker) {
    /*
         * All you modify is data, and the view is driven by data.
         * This is so called data-driven-development. (And yes, it's now in
         * web front end and even with google maps API.)
         */
    const nextMarkers = this.state.markers.filter(marker => marker !== targetMarker);
    this.setState({
      markers: nextMarkers,
    });
  }

  handleSetLat() {
    console.log('and of course');
    this.setState({
      myLatLng: 21765
    });
  }

  render() {
    const {markers, myZoom, myLatLng} = this.state;

    return (
      <div style={{ height: '500px' }}>
        <Helmet
          title="Getting Started"
        />
        <GettingStartedGoogleMap
          containerElement={
            <div style={{ height: '500px' }} />
          }
          mapElement={
            <div style={{ height: '500px' }} />
          }
          onMapLoad={this.handleMapLoad}
          autoLatLng={this.state.myLatLng}
          // onMapClick={this.handleMapClick}
          onMapClick={this.handleMapClick}
          handleSetLat={this.latAutocompleteResult}
          markers={markers}
          // latAutocompleteResult={this.handleSetLat}
          onMarkerRightClick={this.handleMarkerRightClick}
          theZoom={myZoom}
          // theLat={this.state.myLat}
          // theLng={this.state.myLng}
          theLatLng={this.myLatLng``}

        />
      </div>
    );
  }

}

// GettingStartedExample.propTypes = {
//   markers: PropTypes.array,
// };
//
// GettingStartedExample.defaultProps = {
//
// };


export default GettingStartedExample;
