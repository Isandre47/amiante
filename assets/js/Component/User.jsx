import React, {Component} from "react";
import axios from "axios";

class User extends Component {
  constructor() {
    super();
    this.state = {
      users: []
    }
  }

  componentDidMount() {
    this.getUsers();
  }

  getUsers() {
    axios.get('/users').then(users => {
      console.log(users.data)
      this.setState({users: users.data})
    })
  }

  render() {
    return (
        <div>
          Gestion des utilisateurs:
          <div className={'row'}>
            {
              this.state.users.map(user =>
                  <div className="col-md-10 offset-md-1 row-block" key={user.id}>
                    <ul id="sortable">
                      <li>
                        <div className="media">
                          <div className="media-body">
                            <p>{user.email}, {user.lastname}</p>
                          </div>
                          <div className="media-right align-self-center">
                            <a href="#" className="btn btn-default">Contact Now</a>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>)
            }
          </div>
        </div>
    )
  }
}

export default User
