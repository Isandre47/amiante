import React, {useEffect, useState} from "react";
import axios from "axios";

function SiteIndex() {

  const [site, setSite] = useState([]);

  useEffect(() => {
    getSites();
  }, [])

  function getSites() {
    axios.get('/api/site/index').then(sites => {
      console.log('chantier index', sites.data)
      setSite(sites.data.clients)
    })
  }

  return (
      <div>
        <h1>Index des chantiers</h1>
      </div>
  )
}

export default SiteIndex;
