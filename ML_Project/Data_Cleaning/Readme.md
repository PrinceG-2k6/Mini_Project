# Menu-Driven Data Cleaning & Visualization System

## Project Description
This project is a Python-based, menu-driven data cleaning and visualization system. 
It allows users to upload a CSV file and interactively decide how the data should be cleaned and visualized.
The system is designed to simulate real-world data preprocessing workflows used in data analytics and machine learning.

The user can handle missing values, remove duplicates, treat outliers, and generate different types of graphs
based on their choice through a command-line interface.

---

## Features
- Upload any CSV file
- View dataset information and summary
- Handle missing values using:
  - Mean
  - Median
  - Mode
  - Dropping rows
- Remove duplicate records
- Detect and remove outliers using the IQR method
- Generate user-selected visualizations
- Save cleaned data to a new CSV file
- Fully menu-driven system

---

## Technologies Used
- Python
- Pandas
- NumPy
- Matplotlib
- Seaborn
- VS Code

---

## Project Structure
data_cleaning_system/
│
├── data/
│   ├── uploaded.csv
│   └── cleaned.csv
│
├── src/
│   ├── main.py
│   ├── cleaning.py
│   └── visualization.py
│
├── requirements.txt
└── README.md

---

## How to Run
1. Clone the repository
2. Install required libraries:
   pip install -r requirements.txt
3. Run the program:
   python src/main.py
4. Enter the CSV file path when prompted

---

## Menu Options
1. Show dataset information
2. Handle missing values
3. Remove duplicate rows
4. Handle outliers
5. Data visualization
6. Save cleaned data
0. Exit

---

## Visualization Options
- Histogram
- Box Plot
- Count Plot
- Correlation Heatmap

---

## Learning Outcomes
- Practical experience in data cleaning
- Understanding real-world data problems
- Python menu-driven programming
- Data visualization techniques
- Modular coding practices

---

## Future Improvements
- Column-wise data cleaning
- Excel file support
- Web version using Flask or Streamlit
- Logging and report generation

---

## Resume Description
Developed a menu-driven Python system for interactive CSV data cleaning and visualization, 
allowing users to dynamically handle missing values, duplicates, outliers, and generate plots.

---

## License
This project is for educational purposes.
