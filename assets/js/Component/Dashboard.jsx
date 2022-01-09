import React, {Component} from "react";
import axios from "axios";

class Dashboard extends Component {
  constructor() {
    super();
    this.state = {
      users: [],
      equipments: [],
      sites: []
    }
  }

  componentDidMount() {
    this.getUsers();
  }

  getUsers() {
    axios.get('/dashboard_data').then(dash => {
      this.setState({users: dash.data.users})
      this.setState({equipments: dash.data.equipments})
      this.setState({sites: dash.data.sites})
    })
  }

  render() {
    this.state.sites.map(item => console.log(item))
    return (
        <div className={'container-fluid'}>
          <div className={'row m-3'} style={{ height: '4rem'}}>
            <div className={'col-12 text-center'}>
              <h1>Infos générales</h1>
            </div>
          </div>
          <hr/>
          <div className={'row justify-content-around m-3'}>
            <div className={'col-4'}>
              nb utilisateurs dont tant de client {this.state.users.length}
            </div>
            <div className={'col-4'}>
              tant de matos: {this.state.equipments.length}
            </div>
            <div className={'col-4'}>
              Non renseignée
            </div>
          </div>
          <hr/>
          {this.state.sites.length} chantiers
          <br/>
          <div className={'row justify-content-around m-3'}>
            {
              this.state.sites.map(site =>
                  <div className="col-md-10 offset-md-1 row-block" key={site.s_id}>
                    <ul id="sortable" className={'list-unstyled'}>
                      <li>
                        <div className="media">
                          <div className="media-body">
                            <p>{site.s_name} -
                              {site.nbUsers > 0 ? site.nbUsers : 'aucun'} utilisateurs affecté !
                            </p>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
              )
            }
          </div>
        </div>
    )
  }
}

export default Dashboard
