import numpy as np
import pandas as pd 
import matplotlib.pyplot as plt
import seaborn as sns

  
def menu1():
    print("\n===== HANDLIING MISSING VALUE =====")
    print("1. Show All Missing Column")
    print("2. Show All Missing Row")
    print("3. Fill Missing Values")
    print("4. Drop Missing Values")
    print("5. Back")


def handle_missing(df):
    nan_columns_list = df.columns[df.isna().any()].tolist()
    nan_columns= df.columns[df.isna().any()]
    print("===============")
    print("There are Missing values in following columns : ")
    idx=1
    for i in nan_columns_list:
        print(idx,". ",i)
        idx=idx+1
    
    while True:
        
        pd.set_option('display.max_rows', None)
        menu1()
        choice = input("Enter choice: ")
        if choice == '1':
            print(df[nan_columns_list])
        elif choice == '2':
            break
        elif choice == '3':
            break
        elif choice == '4':
            break
        elif choice == '5':
            break
        else:
            print("\n=================================")
            print("Enter Choice Number Correctly!!")
            print("=================================\n")




    
def remove_duplicates(df):
    print(1)

def handle_outliers(df,col):
    print(1)