import React, { useEffect, useState, useRef } from 'react'
import ReactDOM from 'react-dom/client'

function Welcome() {
  const [houses, setHouses] = useState([])
  const [selectedImage, setSelectedImage] = useState(null)
  const [zoom, setZoom] = useState(2)
  const magnifierRef = useRef(null)
  const modalImageRef = useRef(null)

  useEffect(() => {
    fetch('/houses-dashboard') 
      .then((res) => res.json())
      .then((data) => setHouses(data))
      .catch((err) => console.error(err))
  }, [])

  const openModal = (src) => setSelectedImage(src)
  const closeModal = () => setSelectedImage(null)

  const handleMouseMove = (e) => {
    const magnifier = magnifierRef.current
    const image = modalImageRef.current
    if (!magnifier || !image) return

    const rect = image.getBoundingClientRect()
    const x = e.clientX - rect.left
    const y = e.clientY - rect.top
    const bgX = (x / rect.width) * 100
    const bgY = (y / rect.height) * 100

    magnifier.style.left = `${x - magnifier.offsetWidth / 2}px`
    magnifier.style.top = `${y - magnifier.offsetHeight / 2}px`
    magnifier.style.backgroundPosition = `${bgX}% ${bgY}%`
    magnifier.classList.remove('hidden')
  }

  const handleMouseLeave = () => {
    magnifierRef.current?.classList.add('hidden')
  }

  useEffect(() => {
    if (selectedImage && modalImageRef.current && magnifierRef.current) {
      const magnifier = magnifierRef.current
      const image = modalImageRef.current

      magnifier.style.backgroundImage = `url('${selectedImage}')`
      magnifier.style.backgroundSize = `${image.width * zoom}px ${image.height * zoom}px`
    }
  }, [selectedImage, zoom])

  return (
    <div className="bg-gray-100 min-h-screen">

      <header className="bg-white shadow mb-6">
        <div className="container mx-auto flex justify-between items-center p-4">
          <h1 className="text-2xl font-bold text-blue-600">🏠 Zechariah Real Estate</h1>
        </div>
      </header>

      <main className="container mx-auto px-4 py-8">
        <h2 className="text-3xl font-bold text-center mb-8">Available Houses</h2>

        {houses.length > 0 ? (
          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            {houses.map((house) => {
              const imageSrc = house.image
                ? `/storage/${house.image}`
                : '/images/no-image.png'

              return (
                <div
                  key={house.id}
                  className="bg-white rounded-2xl shadow hover:shadow-lg transition p-4"
                >
                  <img
                    src={imageSrc}
                    alt={house.title || 'No Image'}
                    onClick={() => openModal(imageSrc)}
                    className="rounded-lg mb-4 w-full h-64 object-cover cursor-zoom-in"
                  />

                  <h3 className="text-xl font-semibold mb-1">{house.title}</h3>
                  <p className="text-gray-600 mb-1">{house.location}</p>
                  <p className="text-blue-600 font-bold mb-3">
                    ₱{Number(house.price).toLocaleString()}
                  </p>

                  <a
                    href={`/view/house/${house.id}/features`}
                    className="block text-center bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition"
                  >
                    View Details
                  </a>
                </div>
              )
            })}
          </div>
        ) : (
          <p className="text-center text-gray-500">Loading houses...</p>
        )}

        {selectedImage && (
          <div
            className="fixed inset-0 bg-black bg-opacity-80 flex justify-center items-center z-50"
            onClick={(e) => {
              if (e.target.id === 'imageModal') closeModal()
            }}
            id="imageModal"
          >
            <div className="relative">
              <button
                onClick={closeModal}
                className="absolute top-4 right-4 text-white text-3xl font-bold hover:text-red-400 transition"
              >
                &times;
              </button>

              <div className="relative inline-block">
                <img
                  ref={modalImageRef}
                  src={selectedImage}
                  alt="House"
                  onMouseMove={handleMouseMove}
                  onMouseLeave={handleMouseLeave}
                  className="max-h-[90vh] max-w-[90vw] rounded-lg shadow-lg"
                />
                <div
                  ref={magnifierRef}
                  className="hidden absolute w-40 h-40 border-2 border-white rounded-full pointer-events-none"
                  style={{
                    backgroundRepeat: 'no-repeat',
                    backgroundSize: '200%',
                  }}
                ></div>
              </div>
            </div>
          </div>
        )}
      </main>

      <footer className="bg-gray-800 text-white text-center py-4 mt-10">
        © {new Date().getFullYear()} Real Estate Marketplace. All rights reserved.
      </footer>
    </div>
  )
}

ReactDOM.createRoot(document.getElementById('welcome')).render(<Welcome />)
