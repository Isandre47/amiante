import React, {Component} from "react";
import axios from "axios";
import Navbar from "./Navbar.";

class Welcome extends Component {
    constructor(props) {
        super(props);
        this.state = {
          users: []
        }
    }

    componentDidMount() {
      this.getUsers();
    }

    getUsers() {
      axios.get('/users').then(users => {
        console.log(users.data);
        this.setState({users: users.data})
      })
    }

    render() {
        return (
            <div className={'container-fluid'}>
              <div className={'row'}>
                <div className={'col-2 bg-light'}>
                  <Navbar />
                </div>
                <div className={'col-9 shadow bg-light'}>
                  <h2>Bonjour, {this.props.nom}</h2>
                  <ul>
                    { this.state.users.map(user =>
                        <li key={user.id}>{user.email}</li>
                    )}
                  </ul>
                </div>
              </div>
            </div>
        )
    }
}

export default Welcome
