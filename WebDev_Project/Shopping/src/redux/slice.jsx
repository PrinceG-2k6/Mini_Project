import { createSlice } from "@reduxjs/toolkit";

const initialState = {
  items: localStorage.getItem("cart")
    ? JSON.parse(localStorage.getItem("cart"))
    : [],
};

const cartSlice = createSlice({
  name: "cart",
  initialState,
  reducers: {
    addItem: (state, action) => {
      const newItem = action.payload;
      const existingItem = state.items.find((item) => item.id === newItem.id);

      if (existingItem) {
        // If item exists, increase quantity
        existingItem.quantity = (existingItem.quantity || 1) + (newItem.quantity || 1);
      } else {
        // Add as new product with default quantity = 1
        state.items.push({ ...newItem, quantity: newItem.quantity || 1 });
      }

      localStorage.setItem("cart", JSON.stringify(state.items));
    },

    removeItem: (state, action) => {
      const cartData = state.items.filter(
        (item) => item.id !== action.payload.id
      );
      state.items = cartData;
      localStorage.setItem("cart", JSON.stringify(cartData));
    },

    updateQuantity: (state, action) => {
      const { id, quantity } = action.payload;
      state.items = state.items.map((item) =>
        item.id === id ? { ...item, quantity } : item
      );
      localStorage.setItem("cart", JSON.stringify(state.items));
    },

    clearAllItem: (state) => {
        state.items=[]
    },
  },
});

export const { addItem, removeItem, updateQuantity, clearAllItem } =
  cartSlice.actions;
export default cartSlice.reducer;
