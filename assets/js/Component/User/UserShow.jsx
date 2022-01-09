import React, {Component} from "react";
import {useParams} from "react-router-dom";

class UserShow extends Component {
  constructor() {
    super();
    let userId = '';
    console.log('viex page user', userId);
  }

  render() {
    return (
        <div>
          View User
        </div>
    )
  }
}

export default UserShow
