import React from 'react';

export default function Modal({ isOpen, onClose, onConfirm, title, message }) {
  if (!isOpen) return null;

  return (
    <div className="fixed inset-0 flex m-4 mt-8 max-h-max justify-center z-50">
      <div className="fixed inset-0 bg-black opacity-50"></div>
      <div className="bg-gradient-to-r from-brightpurple shadow-lg text-white p-6 rounded shadow-lg z-10">
        <h2 className="text-xl font-bold mb-4">{title}</h2>
        <p className="mb-4">{message}</p>
        <div className="flex justify-end">
          <button
            onClick={onClose}
            className="bg-gray-500 text-white px-4 py-2 rounded-md mr-2"
          >
            Cancel
          </button>
          <button
            onClick={onConfirm}
            className="bg-red-500 text-white px-4 py-2 rounded-md"
          >
            Confirm
          </button>
        </div>
      </div>
    </div>
  );
}
