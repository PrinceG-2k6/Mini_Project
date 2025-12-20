import numpy as np
import pandas as pd 
import matplotlib.pyplot as plt
import seaborn as sns


def visualize(df):
    df_column_list=df.columns.tolist()
    # print(df_column_list)
    print("\nChoose Column To Plot Graph : ")
    for i,col in enumerate(df_column_list):
        print(f"{i+1}. {col}")

    ch = input("Enter the Index of Column e.g.(1,2,..) : ")

    index_list = [int(i.strip()) for i in ch.split(',')]
    
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

