# 📊 Menu-Driven Data Cleaning & Visualization System

## 📌 Project Description

This project is a **Python-based, menu-driven data cleaning and visualization system** designed to simulate **real-world data preprocessing workflows** used in **data analytics and machine learning**.

The system allows users to **upload any CSV file** (or use a built-in Titanic dataset) and interactively perform **data inspection, cleaning, editing, duplicate grouping, outlier treatment, and visualization** using a **command-line interface**.

The program emphasizes **safe preprocessing**, **datatype validation**, and **user-controlled operations**, ensuring that invalid actions (such as forward filling across mixed datatypes) are automatically prevented.

---



## ✨ Features

### 📂 Data Input

* Upload **any CSV file**
* Built-in support for **Titanic dataset**
* Dynamic handling for unknown datasets

---

### 🔍 Data Inspection & Search

* View dataset structure and column information
* Display missing value summary

* Search data dynamically:

  * Exact match for numeric columns
  * Partial match for text columns
    (e.g., searching `Mr` matches `Mr Prince`, `Mr Barry`)


* Clear distinction between:

  * Invalid input
  * Valid input with no matching results

---

### 🧹 Missing Value Handling

* Detect missing values before applying operations
* Forward fill & backward fill:

  * Row-wise and column-wise options
  * Automatically blocked for **mixed datatypes**


* Replace NaN:

  * Single value replacement
  * Column-wise replacement


* Drop missing values:

  * Row-wise or column-wise

---

### 🧬 Duplicate Handling

* Detect duplicate records dynamically
* Group duplicates **by user-selected column(s)**
* Display duplicates **group-wise** instead of flat lists
  (e.g., `Survived = 0` and `Survived = 1` shown as separate groups)
* Supports single-column and multi-column grouping

---

### 📈 Outlier Detection & Treatment

* Detect outliers using the **IQR (Interquartile Range) method**
* User-controlled handling:

  * View outliers
  * Remove outliers
  * Cap outliers (Winsorization)
  * Replace outliers with median
  * Visualize outliers using boxplots

---

### ✏️ Data Editing & Deletion

* Edit a **single cell**
* Edit an **entire row**
* Edit an **entire column**
* Delete operations:

  * Single cell (set to NaN)
  * Single row
  * Bulk row deletion
  * Entire column deletion
* All edits are **datatype-aware** and validated

---

### 📊 Data Visualization

* User-driven visualization menu
* Supported plots:

  * Histogram
  * Box Plot
  * Scatter Plot
  * Line Plot (single & multi-column)
  * Count Plot
  * Bar Plot
  * Missing Value Heatmap
* Advanced visualization features:

  * Datatype validation
  * Column count validation
  * Multi-column plotting support
  * Theme selection (Default, Dark, Grid, Talk, Poster)
  * Automatic legends
  * Optional plot saving

---

## 🛠 Technologies Used

* Python 3
* Pandas
* NumPy
* Matplotlib
* Seaborn
* VS Code

---

## 📁 Project Structure

```
ML_Project/
│
├── Data_Cleaning/
│   ├── Src/
│   │   ├── main.py
│   │   ├── cleaning.py
│   │   ├── visualization.py
│   │   └── Titanic.csv
│   │
│   ├── Data/
│   │   └── cleaned.csv (Appeared when CSV file is saved)
│   │
│   └── Plot/
│       └── saved_plots.png (Appeared when Plot Graph is saved)
│
└── README.md
```

---

## ▶️ How to Run

1. Clone the repository
2. Install required libraries:

   ```bash
   pip install pandas numpy matplotlib seaborn
   ```
3. Run the program:

   ```bash
   python main.py
   ```
4. Enter:

   * `Titanic` to load sample dataset
   * OR provide a custom CSV file path

---

## 📋 Main Menu Options

1. Show dataset information
2. Search data
3. Edit / Delete data
4. Handle missing values
5. Handle duplicates
6. Handle outliers
7. Data visualization
8. Save cleaned data
9. Exit

---

## 📊 Visualization Options

* Histogram
* Box Plot
* Scatter Plot
* Line Plot
* Count Plot
* Bar Plot
* Missing Value Heatmap

---

## 🎓 Learning Outcomes

* Practical experience with real-world data cleaning
* Strong understanding of missing values, duplicates, and outliers
* Menu-driven Python programming
* Safe datatype-aware preprocessing
* Data visualization best practices
* Modular and scalable code design

---



## 🚀 Future Improvements

* Support for Excel files
* Condition-based bulk editing
* Undo / redo functionality
* Logging & preprocessing reports
* Web-based interface using Flask or Streamlit

---

## 📄 License

This project is developed for **educational and learning purposes**.

---
## Summary

Developed a menu-driven Python system for interactive CSV data cleaning and visualization, enabling dynamic handling of missing values, duplicates, outliers, data editing, and advanced plotting with datatype validation and exception safety.

## The Goal Of This Project is To Answer “How do I make data usable?”