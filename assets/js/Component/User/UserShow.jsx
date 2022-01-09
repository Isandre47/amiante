import React, {Component} from "react";
import {useParams} from "react-router-dom";

class UserShow extends Component {
  constructor() {
    super();
    let params = useParams();
  }

  render() {
    return (
        <div>
          View User {params.userId}
        </div>
    )
  }
}

export default UserShow
