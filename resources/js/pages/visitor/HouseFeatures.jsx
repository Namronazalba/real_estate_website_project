import React, { useState, useRef } from "react";

export default function HouseFeatures({ house, features = [] }) {
  const [modalOpen, setModalOpen] = useState(false);
  const [currentImage, setCurrentImage] = useState(null);
  const [magnifierVisible, setMagnifierVisible] = useState(false);
  const [magnifierPosition, setMagnifierPosition] = useState({ x: 0, y: 0 });
  const [backgroundPosition, setBackgroundPosition] = useState({ x: 0, y: 0 });
  const imageRef = useRef();
  const zoom = 2;

  const openModal = (src) => {
    setCurrentImage(src);
    setModalOpen(true);
  };

  const closeModal = () => {
    setModalOpen(false);
    setMagnifierVisible(false);
  };

  const handleMouseMove = (e) => {
    const rect = imageRef.current.getBoundingClientRect();
    const x = e.clientX - rect.left;
    const y = e.clientY - rect.top;

    const bgX = (x / rect.width) * 100;
    const bgY = (y / rect.height) * 100;

    setMagnifierPosition({
      x: x - 80, // half of magnifier width
      y: y - 80,
    });
    setBackgroundPosition({ x: bgX, y: bgY });
  };

    // 📨 Handle contact form submit (added here, before return)
  const handleSubmit = async (e) => {
    e.preventDefault();
    setMessageSent(false);
    setError(null);

    const formData = new FormData(e.target);

    try {
      const response = await fetch(`/view/house/${house.id}/contact`, {
        method: "POST",
        body: formData,
        headers: {
          "X-CSRF-TOKEN": document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute("content"),
        },
      });

      if (response.ok) {
        setMessageSent(true);
        e.target.reset();
      } else {
        setError("Failed to send message. Please try again.");
      }
    } catch (err) {
      console.error(err);
      setError("Something went wrong. Please try again.");
    }
  };
const [messageSent, setMessageSent] = useState(false);
const [error, setError] = useState(null);

  return (
    <div className="container mx-auto px-4 py-8">
      <h2 className="text-3xl font-bold text-center mb-6">{house.title}</h2>
      <p className="text-gray-600 text-center mb-2">{house.location}</p>
      <p className="text-blue-600 text-center text-xl font-bold mb-8">
        ₱{house.price?.toLocaleString()}
      </p>

      {/* Inside Features */}
      {features.length > 0 ? (
        <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
          {features.map((feature, i) => (
            <div
              key={i}
              className="bg-white rounded-lg shadow p-2 cursor-zoom-in hover:shadow-lg transition"
              onClick={() => openModal(`/storage/${feature.image}`)}
            >
              <img
                src={`/storage/${feature.image}`}
                alt={feature.caption || "House Feature"}
                className="rounded-lg w-full h-56 object-cover mb-2"
              />
              {feature.caption && (
                <p className="text-gray-700 text-center font-semibold">
                  {feature.caption}
                </p>
              )}
            </div>
          ))}
        </div>
      ) : (
        <p className="text-center text-gray-500 mt-10">
          No inside photos available for this house yet.
        </p>
      )}

      {/* Contact Form (add this section here) */}
      <section className="mt-16 max-w-3xl mx-auto bg-white shadow rounded-lg p-8">
        <h3 className="text-2xl font-semibold text-gray-800 mb-4 text-center">
          Interested in this Property?
        </h3>
        <p className="text-gray-600 text-center mb-6">
          Fill out the form below and our team will contact you shortly.
        </p>
        {messageSent && (
            <div className="bg-green-100 text-green-700 px-4 py-3 rounded mb-4 text-center">
            Message sent successfully! ✅
            </div>
        )}

        {error && (
            <div className="bg-red-100 text-red-700 px-4 py-3 rounded mb-4 text-center">
            {error}
            </div>
        )}
        <form
        onSubmit={handleSubmit}
        className="space-y-4"
        >

          {/* Laravel CSRF token */}
          <input
            type="hidden"
            name="_token"
            value={document
              .querySelector('meta[name="csrf-token"]')
              ?.getAttribute("content")}
          />

          <div>
            <label className="block text-gray-700 mb-1 font-medium">
              Full Name
            </label>
            <input
              type="text"
              name="name"
              required
              className="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
            />
          </div>

          <div>
            <label className="block text-gray-700 mb-1 font-medium">
              Email Address
            </label>
            <input
              type="email"
              name="email"
              required
              className="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
            />
          </div>

          <div>
            <label className="block text-gray-700 mb-1 font-medium">
              Mobile Number
            </label>
            <input
              type="text"
              name="mobile"
              required
              className="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
            />
          </div>

          <div>
            <label className="block text-gray-700 mb-1 font-medium">
              Message
            </label>
            <textarea
              name="message"
              rows="4"
              required
              className="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 p-2"
            ></textarea>
          </div>

          <div className="text-center">
            <button
              type="submit"
              className="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded-lg transition"
            >
              Send Message
            </button>
          </div>
        </form>
      </section>

      {/* Modal */}
      {modalOpen && (
        <div
          className="fixed inset-0 bg-black bg-opacity-80 flex justify-center items-center z-50"
          onClick={(e) => e.target === e.currentTarget && closeModal()}
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
                ref={imageRef}
                src={currentImage}
                alt="House"
                onMouseMove={handleMouseMove}
                onMouseEnter={() => setMagnifierVisible(true)}
                onMouseLeave={() => setMagnifierVisible(false)}
                className="max-h-[90vh] max-w-[90vw] rounded-lg shadow-lg object-contain"
              />

              {magnifierVisible && (
                <div
                  className="absolute w-40 h-40 border-2 border-white rounded-full pointer-events-none"
                  style={{
                    left: magnifierPosition.x,
                    top: magnifierPosition.y,
                    backgroundImage: `url(${currentImage})`,
                    backgroundRepeat: "no-repeat",
                    backgroundSize: `${imageRef.current?.width * zoom}px ${
                      imageRef.current?.height * zoom
                    }px`,
                    backgroundPosition: `${backgroundPosition.x}% ${backgroundPosition.y}%`,
                    transition: "left 0.05s, top 0.05s",
                  }}
                ></div>
              )}
            </div>
          </div>
        </div>
      )}
    </div>
  );
}
