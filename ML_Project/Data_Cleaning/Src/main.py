import numpy as np
import pandas as pd 
import matplotlib.pyplot as plt
import seaborn as sns

from cleaning import handle_missing, remove_duplicates, handle_outliers
from visualization import visualize



path = input("Enter CSV file path \n(Try 'Titanic' OR Enter Path if you have CSV) : ")
df = None
if path.lower() == "titanic":
    path = "./ML_Project/Data_Cleaning/Src/Titanic.csv"
    df = pd.read_csv(path)
else:
    df = pd.read_csv(path)


print("\nFile uploaded successfully!")


  
def menu():
    print("\n===== DATA CLEANING MENU =====")
    print("0. Show All Data")
    print("1. Show dataset info")
    print("2. Handle missing values")
    print("3. Remove duplicates")
    print("4. Handle outliers")
    print("5. Data visualization")
    print("6. Save cleaned data")
    print("0. Exit")


def show_info(df):
    print("\nDataset Info : \n")
    print(df.info())
    print("\nMissing Values:")
    print(df.isnull().sum())

while True:
    menu()
    choice = int(input("Enter choice: "))

    if choice == 0:
        pd.set_option('display.max_rows', None)
        print(df)
    elif choice == 1:
        show_info(df)
    elif choice == 2:
        handle_missing(df)
    elif choice == 3:
        remove_duplicates(df)
    elif choice == 4:
        col = input("Enter column for outliers: ")
        df = handle_outliers(df, col)
    elif choice == 5:
        visualize(df)
    elif choice == 6:
        df.to_csv("data/cleaned.csv", index=False)
    elif choice == 0:
        break


pd.set_option('display.max_rows', None)
print(df)
  