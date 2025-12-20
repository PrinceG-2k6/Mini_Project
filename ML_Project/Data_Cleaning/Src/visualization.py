import numpy as np
import pandas as pd 
import matplotlib.pyplot as plt
import seaborn as sns

def get_numeric_columns(df):
    return df.select_dtypes(include=['int64', 'float64']).columns.tolist()

def get_categorical_columns(df):
    return df.select_dtypes(include=['object', 'category']).columns.tolist()

def is_valid_index_list(index_list, df):
    return all(1 <= i <= len(df.columns) for i in index_list)


def get_column(df, min_c, max_c):
    while True:
        cols = df.columns.tolist()

        print("\nAvailable Columns:")
        for i, col in enumerate(cols, 1):
            print(f"{i}. {col}")

        ch = input(f"Enter column index (min {min_c}, max {max_c}) e.g.(1,2): ")

        try:
            index_list = [int(i.strip()) for i in ch.split(',')]

            if len(index_list) < min_c or len(index_list) > max_c:
                print("❌ Invalid number of columns selected!")
                continue

            if not is_valid_index_list(index_list, df):
                print("❌ Column index out of range!")
                continue

            return index_list

        except ValueError:
            print("❌ Enter only numbers separated by commas!")



    return index_list


def visualize(df):    
    while True:

        print("===== DATA VISUALIZATION MENU =====")
        print("1. Histogram (Numeric Column)")
        print("2. Box Plot (Outlier Detection)")
        print("3. Scatter Plot (Two Numeric Columns)")
        print("4. Line Plot")
        print("5. Count Plot (Categorical Column)")
        print("6. Bar Plot")
        print("7. Missing Value Heatmap")
        print("8. Back")

        ch = input("Select Graph : ")
        if ch=='1':
            print("\n=================================")
            print("1. Histogram (Numeric Column)")
            print("=================================\n")
            index_list=get_column(df,1,1)

        elif ch=='2':
            print("\n=================================")
            print("2. Box Plot (Outlier Detection)")
            print("=================================\n")
            index_list=get_column(df,1,1)
        elif ch=='3':
            print("\n=================================")
            print("3. Scatter Plot (Two Numeric Columns)")
            print("=================================\n")
            index_list=get_column(df,1,1)
        elif ch=='4':
            print("\n=================================")
            print("Line Plot!!")
            print("=================================\n")
            index_list=get_column(df,1,1)
        elif ch=='5':
            print("\n=================================")
            print("Count Plot (Categorical Column)")
            print("=================================\n")
            index_list=get_column(df,1,1)
        elif ch=='6':
            print("\n=================================")
            print("6. Bar Plot")
            print("=================================\n")
            index_list=get_column(df,1,1)
        elif ch=='7':
            print("\n=================================")
            print("7. Missing Value Heatmap")
            print("=================================\n")
        elif ch=='8':
            break
        else:
            print("\n=================================")
            print("Enter Choice Number Correctly!!")
            print("=================================\n")


