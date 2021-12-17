import React, {Component} from "react";
import Welcome from "./Welcome";

class Home extends Component {

  constructor(props) {
    super(props);
    this.state = {
      name: 'Idiot',
      users: []
    }
  }

  render() {
    return (
        <div>
          <div>
            <Welcome nom={this.state.name}/>
          </div>
        </div>
    )
  }
}

export default Home
