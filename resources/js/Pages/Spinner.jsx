import React from 'react';

const Spinner = () => {
  return (
    <div className="fixed inset-0 flex items-center justify-center bg-gradient-to-r from-brightpurple opacity-60 to-darkpurple bg-opacity-40 z-50">
      <div className="w-10 h-10 border-4 border-t-4 border-black border-t-brightyellow rounded-full animate-spin"></div>
    </div>
  );
};

export default Spinner;
