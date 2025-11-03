import React from 'react'
import ReactDOM from 'react-dom/client'
import HouseFeatures from './pages/visitor/HouseFeatures';

const el = document.getElementById('house-features');
if (el) {
  const house = JSON.parse(el.dataset.house);
  const features = JSON.parse(el.dataset.features);

  ReactDOM.createRoot(el).render(
    <React.StrictMode>
      <HouseFeatures house={house} features={features} />
    </React.StrictMode>
  );
}

