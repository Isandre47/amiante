import React, {useEffect, useState} from "react";
import axios from "axios";
import {Link} from "react-router-dom";

function SiteIndex() {

  const [sites, setSites] = useState([]);

  useEffect(() => {
    getSites();
  }, [])

  function getSites() {
    axios.get('/api/site/index').then(sites => {
      console.log('chantier index', sites.data.sites)
      setSites(sites.data.sites)
    })
  }

  return (
      <div className={'container-fluid'}>
        <div className={'row m-3'} style={{height: '4rem'}}>
          <div className={'col-12 text-center'}>
            <h1>Index des chantiers</h1>
          </div>
        </div>
        <hr/>
        <Link to={'/chantier/add'} className={'nav-link'}>Ajouter un chantier</Link>
        <div className={'row m-3'}>
          <table className={'table table-striped table-hover'}>
            <thead>
              <tr>
                <td>Nom</td>
                <td>Personnels</td>
                <td>Gérer</td>
              </tr>
            </thead>
            <tbody>
            {
              sites.map(site =>
                  <tr key={site.s_id}>
                    <td>{site.s_name}</td>
                    <td>{site.nbUsers}</td>
                    <td>
                      <Link to={`/chantier/edit/${site.s_id}`} className={'nav-link'} edit={'true'}>Editer</Link>
                      -
                      <Link to={`/chantier/show/${site.s_id}`} className={'nav-link'}> Plus d'infos... {site.s_id}</Link>
                    </td>
                  </tr>
              )
            }
            </tbody>
          </table>
        </div>
      </div>
  )
}

export default SiteIndex;
